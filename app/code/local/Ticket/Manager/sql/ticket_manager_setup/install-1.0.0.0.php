<?php

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ticket_manager/ticket'))

    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true, // auto_increment
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Ticket ID')

    ->addColumn('support_id', Varien_Db_Ddl_Table::TYPE_CHAR, 10,
        array(
            'nullable' => false,
        ), 'Support ID')

    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Customer ID')

    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Website ID')

    ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255,
        array(
            'nullable' => false,
        ), 'Message subject')

    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
            'nullable' => false,
        ), 'Message text')

    ->addColumn('active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null,
        array(
            'nullable' => true,
        ), 'Message status')

    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
        array(
            'nullable' => false,
        ), 'Created at')

    // There is no updated_at column because messages have no edit functionality
    // Customer-Administrator communication integrity

    ->setComment('Ticket_Manager Ticket Entity');
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('ticket_manager/reply'))

    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'identity' => true,
            'primary' => true,
            'unsigned' => true,
            'nullable' => false,
        ), 'Reply Id')

    ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Ticket Id')

    ->addColumn('reply', Varien_Db_Ddl_Table::TYPE_TEXT, null,
        array(
            'nullable' => false,
        ), 'Reply text')

    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null,
        array(
            'nullable' => false,
        ), 'Created at')

    // There is no updated_at column because replies have no edit functionality

    ->addForeignKey(
        $installer->getFkName('ticket_manager/reply', 'ticket_id', 'ticket_manager_ticket', 'entity_id'),
        'ticket_id',
        $installer->getTable('ticket_manager_ticket'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, // Delete all replies if message deleted
        Varien_Db_Ddl_Table::ACTION_CASCADE)

    ->setComment('Ticket_Manager Reply Entity');
$installer->getConnection()->createTable($table);

$installer->endSetup();
