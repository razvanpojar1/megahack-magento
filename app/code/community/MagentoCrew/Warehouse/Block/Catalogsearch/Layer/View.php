<?php
/**
 * Block warehouse catalog search filter
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Catalogsearch_Layer_View 
    extends Mage_CatalogSearch_Block_Layer
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
        parent::_initBlocks();
        $this->_warehouseBlockName          = 'mc_warehouse/catalog_layer_filter_warehouse';
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
