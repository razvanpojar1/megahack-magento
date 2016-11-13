<?php
/**
 * Block 
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $warehouseData = Mage::registry('warehouse_data');

        $fieldset = $form->addFieldset('warehouse_form', array('legend' => Mage::helper('mc_warehouse')->__('Warehouse')));

        if ($warehouseData->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('mc_warehouse')->__('Name'),
            'name'  => 'name',
            'required' => true,
            'value' => $warehouseData->getName()
        ));

        $fieldset->addField('code', 'text', array(
            'label' => Mage::helper('mc_warehouse')->__('Code'),
            'name'  => 'code',
            'required' => true,
            'value' => $warehouseData->getCode()
        ));

        $fieldset->addField('email', 'text', array(
            'label' => Mage::helper('mc_warehouse')->__('Email'),
            'name'  => 'email',
            'required' => true,
            'value' => $warehouseData->getEmail()
        ));

        $fieldset->addField('location', 'text', array(
            'label' => Mage::helper('mc_warehouse')->__('Location'),
            'name'  => 'location',
            'required' => true,
            'value' => $warehouseData->getLocation()
        ));

        $form->setValues($warehouseData->getData());

        $form->setUseContainer(false);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}
