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

        if ($data === null) {
            $data = array();
            $data[] = array(
                'label' => Mage::helper('core')->escapeHtml('Cluj'),
                'value' => 1,
                'count' => 1,
            );
            $tags = $this->getLayer()->getStateTags();
            $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
        }
        return $data;
    }
}
