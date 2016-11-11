<?php
/**
 * Warehouse Module
 * @copyright   Copyright (c) 2016 MagentoCrew
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->run("CREATE TABLE `warehouse` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
	`code` VARCHAR(50) NOT NULL COLLATE 'utf8_bin',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_bin',
	`location` TEXT NOT NULL COLLATE 'utf8_bin',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `code` (`code`)
)
COLLATE='utf8_bin'
ENGINE=InnoDB
;

CREATE TABLE `warehouse_product` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`warehouse_id` INT(10) UNSIGNED NOT NULL,
	`product_id` INT(10) UNSIGNED NOT NULL,
	`stock_qty` INT(11) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `FK_warehouse_catalog_product_entity` (`product_id`),
	INDEX `FK_warehouse_product_warehouse` (`warehouse_id`),
	CONSTRAINT `FK_warehouse_catalog_product_entity` FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity` (`entity_id`) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT `FK_warehouse_product_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)
COLLATE='utf8_bin'
ENGINE=InnoDB
;
");
