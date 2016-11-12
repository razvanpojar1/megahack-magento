<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Model_Warehouse extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('mc_warehouse/warehouse');
    }
    
    /**
     * Add warehouse filter to layer
     * 
     * @param Mage_Catalog_Model_Layer $layer
     * @return MagentoCrew_Warehouse_Model_Warehouse
     */
    public function addWarehouseFilterLayerNavigation(Mage_Catalog_Model_Layer $layer)
    {
        $productCollection = $layer->getProductCollection();
        
        $conditions = array(
            'wp_link.product_id=e.entity_id',
        );
        
        $joinCond = join(' AND ', $conditions);
        
        $productCollection->getSelect()->joinLeft(
                array('wp_link' => $this->getResource()->getTable('mc_warehouse/warehouse_product')),
                $joinCond,
                array('warehouse_id')
        );
        
        if ($this->getId()) {
            $productCollection->getSelect()->where('wp_link.warehouse_id = ? ', (int)$this->getId());
        }
        
        return $this;
    }
}
