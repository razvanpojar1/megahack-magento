<?php
/**
 * Model warehouse catalog filter
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Model_Catalog_Layer_Filter_Warehouse 
    extends Mage_Catalog_Model_Layer_Filter_Abstract
{
    /**
     * Active Warehouse Id
     *
     * @var int
     */
    protected $_warehouseId;
    
    /**
     * Set request filter variable
     */
    public function __construct()
    {
        parent::__construct();
        $this->_requestVar = 'warehouse';
    }
    
    /**
     * Get filter name
     *
     * @return string
     */
    public function getName()
    {
        return Mage::helper('mc_warehouse')->__('Warehouse');
    }
    
    /**
     * Apply category filter to layer
     *
     * @param   Zend_Controller_Request_Abstract $request
     * @param   Mage_Core_Block_Abstract $filterBlock
     * @return  MagentoCrew_Warehouse_Model_Catalog_Layer_Filter_Warehouse
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        $filter = (int) $request->getParam($this->getRequestVar());
        if (!$filter) {
            return $this;
        }
        
        $this->_warehouseId = $filter;

        $warehouse = $this->getWarehouse();
        if (is_null($warehouse)) {
            return $this;
        }
        
        Mage::register('current_warehouse_filter', $warehouse, true);
        
        $warehouse->addWarehouseFilterLayerNavigation($this->getLayer());

        $this->getLayer()->getState()->addFilter(
            $this->_createItem($warehouse->getName(), $filter)
        );
        
        return $this;
    }
    
    /**
     * Get data array for building warehouse filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        $key = $this->getLayer()->getStateKey().'_WAREHOUSE';
        $data = $this->getLayer()->getAggregator()->getCacheData($key);

        if (!is_null($data)) {
            return $data;
        }
        
        $data = array();
        
        if (is_null($this->getWarehouse())) {
            $warehouseCollection = Mage::getModel('mc_warehouse/warehouse')
                    ->getCollection()
                    ->getWarehousesFromProductCollection(
                            $this->getLayer()->getProductCollection());
            $data = array();
            foreach ($warehouseCollection as $warehouse) {
                $data[] = array(
                    'label' => Mage::helper('core')->escapeHtml($warehouse->getName()),
                    'value' => $warehouse->getId(),
                    'count' => $warehouse->getProductCount(),
                );
            } 
        }
        
        $tags = $this->getLayer()->getStateTags();
        $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags); 
        
        return $data;
    }
    
    /**
     * Get selected warehouse object
     *
     * @return MagentoCrew_Warehouse_Model_Warehouse
     */
    public function getWarehouse()
    {
        if (!is_null($this->_warehouseId)) {
            $category = Mage::getModel('mc_warehouse/warehouse')
                ->load($this->_warehouseId);
            if ($category->getId()) {
                return $category;
            }
        }
        return null;
    }
}
