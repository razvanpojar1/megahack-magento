<?php
/**
 * Block warehouse catalog product view info
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Catalog_Product_View_Warehouse
    extends Mage_Core_Block_Template
{
    /**
     * Block init
     */
    protected function _construct()
    {
        parent::_construct();
    }
    
    /**
     * Get product warehouses
     * @return array
     */
    public function getWarehouses($productId = null)
    {
        if (is_null($productId)) {
            $productId  = (int)$this->getRequest()->getParam('id');
        }
        
        return Mage::getModel('mc_warehouse/warehouse')
                ->getCollection()
                ->getWarehouseNamesByProductId($productId);
    }
}
