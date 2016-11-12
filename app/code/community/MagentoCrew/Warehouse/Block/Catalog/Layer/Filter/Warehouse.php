<?php
/**
 * Block warehouse catalog filter
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Catalog_Layer_Filter_Warehouse 
    extends Mage_Catalog_Block_Layer_Filter_Abstract
{
    /**
     * Initialize filter model object
     */
    public function __construct()
    {
        parent::__construct();
        $this->_filterModelName = 'mc_warehouse/catalog_layer_filter_warehouse';
    }
}
