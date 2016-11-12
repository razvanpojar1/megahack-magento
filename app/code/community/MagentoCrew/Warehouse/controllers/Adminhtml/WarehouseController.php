<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Adminhtml_WarehouseController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return MagentoCrew_Warehouse_Adminhtml_WarehouseController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_addBreadcrumb(
                Mage::helper('mc_warehouse')->__('Manage Warehouse'),
                Mage::helper('mc_warehouse')->__('Manage Warehouse'))
            ->_addBreadcrumb(
                Mage::helper('mc_warehouse')->__('Manage Warehouse'),
                Mage::helper('mc_warehouse')->__('Manage Warehouse'))
        ;
        return $this;
    }

    /**
     * Render index action
     *
     * @return null
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title($this->__('Manage Warehouse'));
        $this->_setActiveMenu('Manage Warehouse');
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse'))
            ->renderLayout();
    }

    /**
     * Export warehouses as csv format
     *
     * @return null
     */
    public function exportWarehouseCsvAction()
    {
        $fileName = 'warehouse.csv';
        $grid = $this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export warehouses as csv excel format
     *
     * @return null
     */
    public function exportWarehouseExcelAction()
    {
        $fileName = 'warehouse.xml';
        $grid = $this->getLayout()->createBlock('mc_warehouse/adminhtml_warehouse_gridf');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }


    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('warehouse');
    }
}
