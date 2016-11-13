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
        parent::__construct();
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_warehouse';
        $this->_blockGroup= 'mc_warehouse';

        $this->_updateButton('save', 'label', Mage::helper('mc_warehouse')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('mc_warehouse')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('mc_warehouse')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
           function toggleEditor() {
                if (tinyMCE.getInstanceById('file_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'file_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'file_content');
                }
            }
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Update header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if( Mage::registry('warehouse_data') && Mage::registry('warehouse_data')->getId() ) {
            return Mage::helper('mc_warehouse')->__("Edit Warehouse '%s'", $this->escapeHtml(Mage::registry('warehouse_data')->getName()));
        } else {
            return Mage::helper('mc_warehouse')->__('New Warehouse');
        }
    }
}
