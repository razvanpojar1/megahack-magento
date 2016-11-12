<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Init constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('warehouse_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mc_warehouse')->__('Warehouse Information'));
    }

    /**
     * Init tabs structure
     *
     * @return Mage_Core_Block_Abstract
     * @throws Exception
     */
    protected function _beforeToHtml()
    {
        $this->addTab('warehouse_section', array(
            'label'     => Mage::helper('mc_warehouse')->__('Manage Warehouse'),
            'title'     => Mage::helper('mc_warehouse')->__('Manage Warehouse'),
            'content'   => $this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_edit_tab_form')->toHtml(),
            'active'    => true,
        ));

        $this->addTab('warehouse_products', array(
            'label'     => Mage::helper('mc_warehouse')->__('Manage Products'),
            'title'     => Mage::helper('mc_warehouse')->__('Manage Products'),
//            'content'   => $this->getLayout()->createBlock('adminhtml/poll_edit_tab_answers')
//                ->append($this->getLayout()->createBlock('adminhtml/poll_edit_tab_answers_list'))
//                ->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}
