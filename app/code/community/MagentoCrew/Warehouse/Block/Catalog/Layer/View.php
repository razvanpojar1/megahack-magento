<?php
/**
 * Block warehouse catalog filter
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Catalog_Layer_View 
    extends Mage_Catalog_Block_Layer_View
{
    /**
     * Warehouse Block Filter Name
     *
     * @var string
     */
    protected $_warehouseBlockName;
    
    /**
     * Initialize blocks names
     */
    protected function _initBlocks()
    {
        $this->_stateBlockName              = 'catalog/layer_state';
        $this->_categoryBlockName           = 'catalog/layer_filter_category';
        $this->_warehouseBlockName          = 'mc_warehouse/catalog_layer_filter_warehouse';
        $this->_attributeFilterBlockName    = 'catalog/layer_filter_attribute';
        $this->_priceFilterBlockName        = 'catalog/layer_filter_price';
        $this->_decimalFilterBlockName      = 'catalog/layer_filter_decimal';
    }
    
    /**
     * Prepare child blocks
     *
     * @return MagentoCrew_Warehouse_Block_Catalog_Layer_View
     */
    protected function _prepareLayout()
    {
        $warehouseBlock = $this->getLayout()->createBlock($this->_warehouseBlockName)
            ->setLayer($this->getLayer())
            ->init();
        
        $this->setChild('warehouse_filter', $warehouseBlock);
        
        return parent::_prepareLayout();
    }
    
    /**
     * Get all layer filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array();
        
        $categoryFilter = $this->_getCategoryFilter();
                
        if ($categoryFilter) {
            $filters[] = $categoryFilter;
        }
        
        $warehouseFilter = $this->getChild('warehouse_filter');
        
        if ($warehouseFilter) {
            $filters[] = $warehouseFilter;
        }

        $filterableAttributes = $this->_getFilterableAttributes();
        foreach ($filterableAttributes as $attribute) {
            $filters[] = $this->getChild($attribute->getAttributeCode() . '_filter');
        }

        return $filters;
    }
}
