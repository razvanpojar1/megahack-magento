<?php
/**
 * Warehouse Default Helper
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Helper_Data extends Mage_Core_Helper_Data
{


    /**
     * Is module enabled?
     *
     * @return bool
     */
    public function isEnable() {
        return Mage::getStoreConfigFlag('mc_warehouse/general/enable');
    }

}
