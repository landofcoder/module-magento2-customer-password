<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_CustomerPassword
 * @copyright  Copyright (c) 2022 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\CustomerPassword\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class InstallSchema
 *
 * @package Lof\CustomerPassword\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'lof_customer_password_log'
         */
        $tableName = $setup->getTable('lof_customer_password_log');
        $lof_customer_password_log = $installer->getConnection()->newTable(
            $tableName
        )->addColumn(
            'passwordlog_id',
            Table::TYPE_INTEGER,
            10,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
            'Entity ID'
        )->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            10,
            [],
            'customer_id'
        )->addColumn(
            'customer_email',
            Table::TYPE_TEXT,
            255,
            [],
            'Customer Email'
        )->addColumn(
            'admin_username',
            Table::TYPE_TEXT,
            255,
            [],
            'Admin Username'
        )->addColumn(
            'admin_id',
            Table::TYPE_INTEGER,
            10,
            [],
            'Admin Id'
        )->addColumn(
            'admin_name',
            Table::TYPE_TEXT,
            255,
            [],
            'Admin Name'
        )->addColumn(
            'ip',
            Table::TYPE_TEXT,
            255,
            [],
            'IP Address'
        )->addColumn(
            'logged_at',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'logged_at'
        )->addIndex(
            $setup->getIdxName(
                $tableName,
                ['customer_email'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['customer_email'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        );

        $setup->getConnection()->createTable($lof_customer_password_log);

        $setup->endSetup();
    }
}
