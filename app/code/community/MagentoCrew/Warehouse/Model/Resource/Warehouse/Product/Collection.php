<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Model_Resource_Warehouse_Product_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_isWarehouseJoined = false;

    /**
     * Collection init
     */
    protected function _construct()
    {
        $this->_init('mc_warehouse/warehouse_product');
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
        $this->addFieldToFilter('product_id', array('eq' => $productId));

        if ($minQty) {
            $this->addFieldToFilter('stock_qty', array('gteq' => $minQty));
        }
        return $this;
    }

    public function addWarehouseInfo($warehouseFields)
    {
        if (!$this->_isWarehouseJoined) {

            if (empty($warehouseFields)) {
                $warehouseFields = array(
                    'warehouse_name' => 'name'
                );
            } elseif (!is_array($warehouseFields)) {
                throw new InvalidArgumentException('Invalid warehouse fields!');
            }

            $this->getSelect()
                ->join(
                    array('warehouse' => $this->getTable('mc_warehouse/warehouse')),
                    'main_table.warehouse_id = warehouse.id',
                    $warehouseFields)
            ;
            $this->_isWarehouseJoined = true;
        }
        return $this;
    }
}
