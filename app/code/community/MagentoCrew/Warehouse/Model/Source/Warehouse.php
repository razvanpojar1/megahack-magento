<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Model_Source_Warehouse
{
    protected $_options;

    public function toOptionArray($isMultiselect=false)
    {
        if (!$this->_options) {
            /** @var MagentoCrew_Warehouse_Model_Resource_Warehouse_Collection $collection */
            $collection = Mage::getResourceModel('mc_warehouse/warehouse_product_collection')->loadData();
            $this->_options = $collection->toOptionArray(false);
        }

        $options = $this->_options;
        if (!$isMultiselect) {
            array_unshift($options, array('value'=>'', 'label'=> Mage::helper('mc_warehouse')->__('--Please Select--')));
        }

        return $options;
    }
}