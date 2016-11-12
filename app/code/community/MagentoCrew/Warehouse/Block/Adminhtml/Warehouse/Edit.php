<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init container
     */
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'warehouse';

        parent::__construct();
    }
}
