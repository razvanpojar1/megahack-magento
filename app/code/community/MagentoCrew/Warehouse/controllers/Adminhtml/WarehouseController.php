<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Adminhtml_WarehouseController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return MagentoCrew_Warehouse_Adminhtml_WarehouseController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_addBreadcrumb(
                Mage::helper('mc_warehouse')->__('Manage Warehouse'),
                Mage::helper('mc_warehouse')->__('Manage Warehouse'))
            ->_addBreadcrumb(
                Mage::helper('mc_warehouse')->__('Manage Warehouse'),
                Mage::helper('mc_warehouse')->__('Manage Warehouse'))
        ;
        return $this;
    }

    /**
     * Render index action
     *
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__('Manage Warehouse'));
        $this->_setActiveMenu('Manage Warehouse');
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_warehouse'))
            ->renderLayout();
    }

    /**
     * Forward to edit action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Render index action
     *
     */
    public function editAction()
    {
        $this->_title($this->__('Warehouse edit'));

        $warehouseId = $this->getRequest()->getParam('id');
        $warehouseModel  = Mage::getModel('mc_warehouse/warehouse')->load($warehouseId);

        if ($warehouseModel->getId() || $warehouseId == 0) {
            $this->_title($warehouseModel->getId() ? $warehouseModel->getName() : $this->__('New warehouse'));

            Mage::register('warehouse_data', $warehouseModel);
            $this->loadLayout();

            $this->_setActiveMenu('Edit Warehouse');
            $this->_addBreadcrumb(Mage::helper('mc_warehouse')->__('Warehouse Manager'), Mage::helper('mc_warehouse')->__('Warehouse Manager'), $this->getUrl('*/*/'));
            $this->_addBreadcrumb(Mage::helper('mc_warehouse')->__('Edit Warehouse'), Mage::helper('mc_warehouse')->__('Edit Warehouse'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_edit'))
                ->_addLeft($this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mc_warehouse')->__('The warehouse does not exist.'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * Save action
     *
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $warehouseModel = Mage::getModel('mc_warehouse/warehouse');

            if ($warehouseId = $this->getRequest()->getParam('id')) {
                $warehouseModel->setData($data)
                    ->setId($warehouseId);
            } else {
                $warehouseModel->setData($data);
            }

            try {
                $warehouseModel->save();

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $warehouseModel->getId()));
                    return;
                }

                Mage::getSingleton('adminhtml/session')->addSuccess('Warehouse successfully saved');
                $this->_redirect('*/*/');
            }
            catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError('An error has occured. Please try again');
                Mage::getSingleton('adminhtml/session')->setExampleFormData($data);
                $this->_redirect('*/*/edit', array('id' => $warehouseModel->getId(), '_current'=>true));
            }
        }
    }

    /**
     * Delete action
     *
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('mc_warehouse/warehouse')->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mc_warehouse')->__('The warehouse has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find a warehouse to delete.'));
        $this->_redirect('*/*/');
    }

    /**
     * Export warehouses as csv format
     *
     * @return null
     */
    public function exportWarehouseCsvAction()
    {
        $fileName = 'warehouse.csv';
        $grid = $this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export warehouses as csv excel format
     *
     * @return null
     */
    public function exportWarehouseExcelAction()
    {
        $fileName = 'warehouse.xml';
        $grid = $this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_gridf');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    /**
     * Check if module is allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('warehouse');
    }

    /**
     * Get warehouse products grid and serializer block
     */
    public function relatedAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('mc.warehouse.edit.tab.products');
        $this->renderLayout();
    }
    
    /**
     * Get related products grid
     */
    public function relatedGridAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('mc.warehouse.edit.tab.products')
            ->setProductsRelated($this->getRequest()->getPost('products_related', null));
        $this->renderLayout();
    }
}
