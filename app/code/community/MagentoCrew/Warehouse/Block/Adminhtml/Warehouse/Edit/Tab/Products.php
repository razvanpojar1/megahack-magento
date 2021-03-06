<?php
/**
 * Block 
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Edit_Tab_Products 
    extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set grid params
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('warehouse_products_grid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);

        if ($this->getWarehouseId()) {
            $this->setDefaultFilter(array('in_products' => 1));
        }
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'in_products',
            'values'            => $this->_getSelectedProducts(),
            'align'             => 'center',
            'index'             => 'entity_id'
        ));

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('catalog')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('catalog')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => 80,
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'        => Mage::helper('catalog')->__('Price'),
            'type'          => 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'         => 'price'
        ));

        $this->addColumn('stock_qty', array(
            'header'                    => Mage::helper('mc_warehouse')->__('Stock Qty'),
            'name'                      => 'stock_qty',
            'type'                      => 'number',
            'validate_class'            => 'validate-number',
            'index'                     => 'stock_qty',
            'width'                     => 60,
            'editable'                  => 1,
            'filter_condition_callback' => array($this, '_addWarehouseModelFilterCallback')
        ));

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getData('grid_url')
            ? $this->getData('grid_url')
            : $this->getUrl('*/*/relatedGrid', array('_current' => true));
    }
    
    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*');
        
        $collection->getSelect()
            ->joinLeft(
                array('warehouse_product' => $collection->getResource()->getTable('mc_warehouse/warehouse_product')),
                'warehouse_product.product_id = e.entity_id and warehouse_product.warehouse_id = '.(int)$this->getWarehouseId(),
                array('warehouse_product.stock_qty')
            );
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    /**
     * Retrieve selected related products
     *
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getProductsRelated();

        if (!is_array($products)) {
            $products = array_keys($this->getWarehouseProducts());
        }
        return $products;
    }

    /**
     * Get product collection by warehouse id
     *
     * @param int $warehouseId
     * @return MagentoCrew_Warehouse_Model_Resource_Warehouse_Product_Collection
     */
    public function getWarehouseProducts()
    {
        $warehouseProducts = Mage::getModel('mc_warehouse/warehouse_product')->getCollection();
        $warehouseProducts->addFieldToFilter('warehouse_id', array('eq' => (int)$this->getWarehouseId()));
        $warehouseProducts->load();

        if (!count($warehouseProducts)) {
            return array();
        }

        $products = array();
        foreach ($warehouseProducts as $item) {
            $products[$item->getProductId()] = array('stock_qty' => $item->getStockQty());
        }
        
        return $products;
    }
    
    /**
     * Warehouse internal id
     * @return int
     */
    public function  getWarehouseId()
    {
        return (int)$this->getRequest()->getParam('id');
    }
    
    /**
     * Add filter
     *
     * @param object $column
     * @return MagentoCrew_Warehouse_Block_Adminhtml_Warehouse_Edit_Tab_Products
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}