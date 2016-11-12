<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Init construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('warehouseId');
        $this->setDefaultSort('id');
        $this->setSaveParametersInSession(true);
        $this->setDefaultDir('ASC');
        $this->setUseAjax(false);
    }

    /**
     * Get and set collection
     *
     * @return MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mc_warehouse/warehouse')->getCollection();
        /* @var $collection MagentoCrew_Warehouse_Model_Resource_Warehouse_Collection */
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('mc_warehouse')->__('Id'),
            'index'     => 'id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('mc_warehouse')->__('Warehouse name'),
            'index'     => 'name',
        ));

        $this->addColumn('code', array(
            'header'    => Mage::helper('mc_warehouse')->__('Warehouse code'),
            'index'     => 'code',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('mc_warehouse')->__('Warehouse email'),
            'index'     => 'email',
        ));

        $this->addColumn('location', array(
            'header'    => Mage::helper('mc_warehouse')->__('Warehouse location'),
            'index'     => 'location',
        ));

        $this->addExportType('*/*/exportWarehouseCsv', Mage::helper('mc_warehouse')->__('CSV'));
        $this->addExportType('*/*/exportWarehouseExcel', Mage::helper('mc_warehouse')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * Row edit click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
