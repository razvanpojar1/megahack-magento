<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Warehouse extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup = 'mc_warehouse';
        $this->_headerText = Mage::helper('mc_warehouse')->__('Manage Warehouse');
        $this->_addButtonLabel = Mage::helper('mc_warehouse')->__('Add warehouse');
        parent::__construct();

    }
}
