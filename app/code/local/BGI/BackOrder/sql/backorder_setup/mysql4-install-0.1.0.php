<?php
$installer = $this;

$installer->startSetup();

$installer->run("

		-- DROP TABLE IF EXISTS {$this->getTable('backorder')};
		CREATE TABLE {$this->getTable('backorder')} (
		`backorder_id` int(11) unsigned NOT NULL auto_increment,
		`customer_id` int(11) NOT NULL,
		`send_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
		PRIMARY KEY (`backorder_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");

$installer->endSetup();