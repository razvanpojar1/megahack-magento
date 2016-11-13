<?php
/**
 * Warehouse Module
 *
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$tableNameWarehouseProduct = $installer->getTable('mc_warehouse/warehouse_product');

//Add unique index to force the records to be unique
$installer->getConnection()->addIndex(
    $tableNameWarehouseProduct,
    $installer->getIdxName(
        'mc_warehouse/warehouse_product',
        array('warehouse_id', 'product_id'),
        Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    ),
    array('warehouse_id', 'product_id'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$installer->endSetup();
