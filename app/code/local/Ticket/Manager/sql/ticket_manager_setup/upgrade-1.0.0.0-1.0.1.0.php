<?php

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;
$installer->startSetup();

$installer->getConnection()

    ->addColumn($installer->getTable('ticket_manager/reply'), 'owner',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            'comment' => 'Reply owner (Customer 0, admin 1)'
        )
    );

$installer->endSetup();
