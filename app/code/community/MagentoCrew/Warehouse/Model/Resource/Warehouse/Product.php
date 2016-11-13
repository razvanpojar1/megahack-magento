<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Model_Resource_Warehouse_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource init
     */
    protected function _construct()
    {
        $this->_init('mc_warehouse/warehouse_product', 'id');
    }

    /**
     * Get Id based on info
     *
     * @param int $productId
     * @param int $warehouseId
     * @return int
     */
    public function getIdFromInfo($productId, $warehouseId)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), 'id')
            ->where('warehouse_id = ?', (int) $warehouseId)
            ->where('product_id = ?', (int) $productId)
        ;
        $read = $this->_getReadAdapter();

        return $read->fetchCol($select);
    }
}
