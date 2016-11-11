<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MagentoCrew_Warehouse_Model_Resource_Warehouse_Product extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('dataflow/import', 'import_id');
    }
}
