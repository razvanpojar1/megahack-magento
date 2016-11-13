<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Model_Warehouse_Product extends Mage_Core_Model_Abstract
{
    /**
     * Model init
     */
    public function _construct()
    {
        $this->_init('mc_warehouse/warehouse_product');
    }

    /**
     * Get Id based on info
     *
     * @param int $productId
     * @param int $warehouseId
     * @return int
     */
    public function loadFromInfo($productId, $warehouseId)
    {
        $id = $this->getResource()->getIdFromInfo($productId, $warehouseId);
        return $this->load($id);
    }
}
