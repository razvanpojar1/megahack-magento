<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Model_Resource_Warehouse_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * @var bool
     */
    protected $_isProductsJoined = false;

    /**
     * Collection init
     */
    protected function _construct()
    {
        $this->_init('mc_warehouse/warehouse');
    }
    
     /**
     * Collect warehouses from product collection
     * 
     * @param Mage_Catalog_Model_Resource_Product_Collection $productCollection
     * @return MagentoCrew_Warehouse_Model_Resource_Warehouse
     */
    public function getWarehousesFromProductCollection(Mage_Catalog_Model_Resource_Product_Collection $productCollection)
    {
        $select = $this->_getProductCountSelect($productCollection);
        
        $productCounts = $this->getConnection()->fetchPairs($select);
        
        $warehouseIds = array_keys($productCounts);
        
        if (count($warehouseIds)) {
            $this->addFieldToFilter('main_table.id', array('in' => $warehouseIds));
        } else {
            // force empty collection if products from collection do not have assigned warehouses
            $this->_setIsLoaded();
        }
        $this->load();
        
        foreach ($this->getItems() as $warehouse) {
            $_count = 0;
            if (isset($productCounts[$warehouse->getId()])) {
                $_count = $productCounts[$warehouse->getId()];
            }
            $warehouse->setProductCount($_count);
        }
        
        return $this;
    }
    
    /**
     * Retreive product count select for warehouses
     * 
     * @param Mage_Catalog_Model_Resource_Product_Collection $productCollection
     * @return Varien_Db_Select
     */
    protected function _getProductCountSelect(Mage_Catalog_Model_Resource_Product_Collection $productCollection)
    {
        $productCountSelect = clone $productCollection->getSelect();
        $productCountSelect->reset(Zend_Db_Select::COLUMNS)
            ->reset(Zend_Db_Select::GROUP)
            ->reset(Zend_Db_Select::ORDER)
            ->distinct(false)
            ->join(array('count_table' => $this->getTable('mc_warehouse/warehouse_product')),
                'count_table.product_id = e.entity_id',
                array(
                    'count_table.warehouse_id',
                    'product_count' => new Zend_Db_Expr('COUNT(DISTINCT count_table.product_id)')
                )
            )
            ->group('count_table.warehouse_id');
        $productCountSelect->limit(); //reset limits

        return $productCountSelect;
    }
    
    public function getWarehouseNamesByProductId($productId)
    {
        if (!$productId) {
            return array();
        }
        
        $select = $this->getSelect()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('name'))
            ->join(array('warehouse_product' => $this->getTable('mc_warehouse/warehouse_product')),
                'warehouse_product.warehouse_id = main_table.id',
                array())
            ->where('warehouse_product.product_id = ?', (int)$productId );
        
        return $this->getConnection()->fetchCol($select);
    }

    /**
     * Add Product filter with optional minQty
     *
     * @param int $productId
     * @param null $minQty
     * @return $this
     */
    public function addProductFilter($productId, $minQty = null)
    {
        $adapter = $this->getConnection();
        if (!$this->_isProductsJoined) {
            $this->getSelect()
                ->join(
                    array('product' => $this->getTable('mc_warehouse/warehouse_product')),
                    $adapter->quoteInto('main_table.id = product.warehouse_id and product.product_id = ?', (int) $productId),
                    array('stock_qty' => 'product.stock_qty'))
            ;
            $this->_isProductsJoined = true;
        }

        $this->getSelect()->where('product.product_id', array('eq' => $productId));

        if ($minQty) {
            $this->getSelect()->where('product.stock_qty >= ?', (int) $minQty);
        }
        return $this;
    }



}
