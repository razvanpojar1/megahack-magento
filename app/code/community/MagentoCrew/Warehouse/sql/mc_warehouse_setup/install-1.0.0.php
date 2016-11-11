<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$tableNameWarehouse = $installer->getTable('mc_warehouse/warehouse');

if (!$installer->getConnection()->isTableExists($tableNameWarehouse)) {
    /**
     * Create table 'mc_warehouse/warehouse'
     */
    $tableWarehouse = $installer->getConnection()
        ->newTable($tableNameWarehouse)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
            ), 'Warehouse Id')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
            'nullable'  => false
            ), 'Warehouse Name')
        ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
            'nullable'  => false
            ), 'Warehouse Code')
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false
            ), 'Warehouse Email')    
        ->addColumn('location', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable'  => false
            ), 'Warehouse Location')
        ->addIndex($installer->getIdxName('mc_warehouse/warehouse', array('id')),
            array('id'))
        ->addIndex($installer->getIdxName('mc_warehouse/warehouse', array('code')),
            array('code'), array('type' => 'UNIQUE'))
        ->setComment('Warehouse');
    $installer->getConnection()->createTable($tableWarehouse);
}

$tableNameWarehouseProduct = $installer->getTable('mc_warehouse/warehouse_product');

if (!$installer->getConnection()->isTableExists($tableNameWarehouseProduct)) {
    /**
     * Create table 'mc_warehouse/warehouse_product'
     */
    $tableWarehouseProduct = $installer->getConnection()
        ->newTable($tableNameWarehouseProduct)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true
            ), 'Primary Id')
        ->addColumn('warehouse_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false
            ), 'Warehouse Id')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false
            ), 'Product Id')
        ->addForeignKey($installer->getFkName('mc_warehouse/warehouse_product', 'warehouse_id', 'mc_warehouse/warehouse', 'id'),
            'warehouse_id', $installer->getTable('mc_warehouse/warehouse'), 'id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName('mc_warehouse/warehouse_product', 'product_id', 'catalog/product', 'entity_id'),
            'product_id', $installer->getTable('catalog/product'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Warehouse Product');
    $installer->getConnection()->createTable($tableWarehouseProduct);
}

$installer->endSetup();
