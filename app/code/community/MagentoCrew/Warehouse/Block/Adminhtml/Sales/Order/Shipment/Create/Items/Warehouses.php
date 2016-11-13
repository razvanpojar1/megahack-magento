<?php
/**
 * Block item warehouses selection drop down
 *
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Adminhtml_Sales_Order_Shipment_Create_Items_Warehouses extends Mage_Adminhtml_Block_Template
{
    /**
     * Get order item object from parent block
     *
     * @return Mage_Sales_Model_Order_Item
     */
    public function getItem()
    {
        return $this->getParentBlock()->getData('item');
    }

    /**
     * Get Available Warehouses
     *
     * @return MagentoCrew_Warehouse_Model_Warehouse[]|MagentoCrew_Warehouse_Model_Resource_Warehouse_Collection
     */
    public function getAvailableWarehouses()
    {
        /** @var MagentoCrew_Warehouse_Model_Resource_Warehouse_Collection $warehouses */
        $warehouses = Mage::getResourceModel('mc_warehouse/warehouse_collection');
        $warehouses->addProductFilter($this->getItem()->getProductId(), 1);

        return $warehouses;
    }
}