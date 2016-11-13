<?php
/**
 * Warehouse Module
 *
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->getConnection()
    ->addColumn($installer->getTable('sales/shipment'), 'warehouse_id', array(
        'TYPE'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'UNSIGNED'  => true,
        'NULLABLE'  => true,
        'COMMENT'   => 'Warehouse Id'
    ));

$installer->endSetup();
