<?php
/**
 * Warehouse Shipping controller
 *
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml').DS.'Sales'.DS.'Order'.DS.'ShipmentController.php';

class MagentoCrew_Warehouse_Adminhtml_Sales_Order_ShipmentController extends Mage_Adminhtml_Sales_Order_ShipmentController
{
    /**
     * @var null|MagentoCrew_Warehouse_Helper_Data
     */
    protected $_helper = null;

    /**
     * @var MagentoCrew_Warehouse_Model_Warehouse[]
     */
    protected $_warehouses = array();

    /**
     * Additional initialization
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_helper = Mage::helper('mc_warehouse');
    }

    /**
     * Get warehouse
     *
     * @param int $warehouseId
     * @return MagentoCrew_Warehouse_Model_Warehouse
     */
    protected function _getWarehouse($warehouseId)
    {
        if (empty($this->_warehouses[$warehouseId])) {
            $this->_warehouses[$warehouseId] = Mage::getModel('mc_warehouse/warehouse')->load($warehouseId);
        }
        return $this->_warehouses[$warehouseId];
    }

    /**
     * Initialize shipment items Warehouse ID
     *
     * @return array
     * @throws Exception
     */
    protected function _getWarehouseIds()
    {
        $data = $this->getRequest()->getParam('shipment');
        if (isset($data['warehouses'])) {
            $warehouses = $data['warehouses'];
        } else {
            throw new Exception('Invalid warehouse parameters!');
        }
        return $warehouses;
    }

    /**
     * Save shipment
     * We can save only new shipment. Existing shipments are not editable
     *
     * @return null
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost('shipment');
        if (!empty($data['comment_text'])) {
            Mage::getSingleton('adminhtml/session')->setCommentText($data['comment_text']);
        }

        try {
            $shipment = $this->_initShipment();

            if (!$shipment) {
                $this->_forward('noRoute');
                return;
            }

            $responseAjax = new Varien_Object();
            $isNeedCreateLabel = isset($data['create_shipping_label']) && $data['create_shipping_label'];


            $needRedirectEditPage = true;
            $this->_initWarehouseItems($shipment);

            $this->_validateSingleWarehouse();
            $this->_validateWarehouseStock($shipment);
            $needRedirectEditPage = false;

            $shipment->register();
            $comment = '';
            if (!empty($data['comment_text'])) {
                $shipment->addComment(
                    $data['comment_text'],
                    isset($data['comment_customer_notify']),
                    isset($data['is_visible_on_front'])
                );
                if (isset($data['comment_customer_notify'])) {
                    $comment = $data['comment_text'];
                }
            }

            if (!empty($data['send_email'])) {
                $shipment->setEmailSent(true);
            }

            $shipment->getOrder()->setCustomerNoteNotify(!empty($data['send_email']));

            if ($isNeedCreateLabel && $this->_createShippingLabel($shipment)) {
                $responseAjax->setOk(true);
            }

            $this->_saveShipment($shipment);
            //decreases stock from the warehouse_product table for the selected products
            $this->_saveWarehouseItemsStock($shipment);

            $shipment->sendEmail(!empty($data['send_email']), $comment);

            $shipmentCreatedMessage = $this->__('The shipment has been created.');
            $labelCreatedMessage    = $this->__('The shipping label has been created.');

            $this->_getSession()->addSuccess($isNeedCreateLabel ? $shipmentCreatedMessage . ' ' . $labelCreatedMessage
                : $shipmentCreatedMessage);
            Mage::getSingleton('adminhtml/session')->getCommentText(true);
        } catch (Mage_Core_Exception $e) {
            if ($isNeedCreateLabel) {
                $responseAjax->setError(true);
                $responseAjax->setMessage($e->getMessage());
            } else {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/new', array('order_id' => $this->getRequest()->getParam('order_id')));
            }
        } catch (Exception $e) {
            Mage::logException($e);
            if ($isNeedCreateLabel) {
                $responseAjax->setError(true);
                $responseAjax->setMessage(
                    Mage::helper('sales')->__('An error occurred while creating shipping label.'));
            } else {
                $this->_getSession()->addError($this->__('Cannot save shipment.'));
                $this->_redirect('*/*/new', array('order_id' => $this->getRequest()->getParam('order_id')));
            }

        }
        if ($isNeedCreateLabel) {
            $this->getResponse()->setBody($responseAjax->toJson());
        } elseif ($needRedirectEditPage) {
            $this->_redirect('*/sales_order_shipment/new', array('order_id' => $shipment->getOrderId()));
        } else {
            $this->_redirect('*/sales_order/view', array('order_id' => $shipment->getOrderId()));
        }
    }

    /**
     * Init warehouse items associated to shipment items
     *
     * - throws some errors related to input parameters
     *
     * @param Mage_Sales_Model_Order_Shipment $shipment
     * @throws Mage_Core_Exception|Exception
     */
    protected function _initWarehouseItems($shipment)
    {
        $warehouses = $this->_getWarehouseIds();

        foreach ($shipment->getAllItems() as $item) {
            /** @var Mage_Sales_Model_Order_Shipment_Item $item */

            if (!isset($warehouses[$item->getOrderItemId()])) {
                throw new Exception('Invalid warehouse parameter for order item SKP: ' . $item->getSku());
            }
            $warehouseId = $warehouses[$item->getOrderItemId()];

            /** @var MagentoCrew_Warehouse_Model_Warehouse_Product $warehouseItem */
            $warehouseItem = Mage::getModel('mc_warehouse/warehouse_product');
            $warehouseItem = $warehouseItem->loadFromInfo($item->getProductId(), $warehouseId);

            $item->setWarehouseItem($warehouseItem);
            $shipment->setWarehouseId($warehouseId);
        }
    }

    /**
     * Validate single warehouse
     *
     * - All products from a shipping should be shipped from one warehouse
     *
     * @throws Mage_Core_Exception|Exception
     */
    protected function _validateSingleWarehouse()
    {
        $firstWarehouseId = null;
        $warehouses = $this->_getWarehouseIds();

        foreach ($warehouses as $orderId => $warehouseId) {
            /** @var Mage_Sales_Model_Order_Shipment_Item $item */
            if (is_null($firstWarehouseId)) {
                $firstWarehouseId = $warehouseId;
            } elseif ($firstWarehouseId != $warehouseId) {
                Mage::throwException($this->_helper->__('The shipment needs to be done only from one warehouse!'));
            }
        }
    }

    /**
     * Validate warehouse stock
     *
     * - The product selected to be shipped should have stock in that warehouse
     *
     * @param Mage_Sales_Model_Order_Shipment $shipment
     * @throws Mage_Core_Exception|Exception
     */
    protected function _validateWarehouseStock($shipment)
    {
        foreach ($shipment->getAllItems() as $item) {
            /** @var Mage_Sales_Model_Order_Shipment_Item $item */

            /** @var MagentoCrew_Warehouse_Model_Warehouse_Product $warehouseItem */
            $warehouseItem = $item->getWarehouseItem();
            $warehouse = $this->_getWarehouse($warehouseItem->getWarehouseId());

            if (!$warehouseItem->getId() || $warehouseItem->getStockQty() <= 0) {
                //Warehouse item was not found
                $message = $this->_helper->__('The product "%s" is no longer available in the warehouse "%s"!', $item->getName(), $warehouse->getName());
                Mage::throwException($message);
            }

            if (!$warehouseItem->getStockQty() || $warehouseItem->getStockQty() < $item->getQty()) {
                //Warehouse item has insufficient stock
                $message = $this->_helper->__('The product "%s" stock quantity from the warehouse "%s" is insufficient! Stock qty is %d.',
                    $item->getName(), $warehouse->getName(), $warehouseItem->getStockQty());
                Mage::throwException($message);
            }

        }
    }

    /**
     * Save warehouse items stock
     *
     * - Decreases stock from the warehouse_product table for the selected products
     *
     * @param Mage_Sales_Model_Order_Shipment $shipment
     * @throws Mage_Core_Exception|Exception
     * @return $this
     */
    protected function _saveWarehouseItemsStock($shipment)
    {
        $transactionSave = Mage::getModel('core/resource_transaction');

        foreach ($shipment->getAllItems() as $item) {
            /** @var Mage_Sales_Model_Order_Shipment_Item $item */

            /** @var MagentoCrew_Warehouse_Model_Warehouse_Product $warehouseItem */
            $warehouseItem = $item->getWarehouseItem();

            $warehouseItem->decreaseStockQty($item->getQty());
            $transactionSave->addObject($warehouseItem);
        }

        $transactionSave->save();

        return $this;
    }
}