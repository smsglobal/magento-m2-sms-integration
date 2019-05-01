<?php
/**
 * SMSGlobal SMS Integration with Magento developed by SMSGlobal Team (Allam Praveen)
 * Copyright (C) 2018  SMSGlobal
 *
 * This file included in Smsglobal/Sms is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Smsglobal\Sms\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        //Your install script

        $table_smsglobal_sms_smslog = $setup->getConnection()->newTable($setup->getTable('smsglobal_smslog'));

        $table_smsglobal_sms_smslog->addColumn(
            'log_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'auto_increment' => true,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );


        $table_smsglobal_sms_smslog->addColumn(
            'msg_date',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
            null,
            [],
            'msg_date'
        );

        $table_smsglobal_sms_smslog->addColumn(
            'origin',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'origin'
        );

        $table_smsglobal_sms_smslog->addColumn(
            'destination',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'destination'
        );

        $table_smsglobal_sms_smslog->addColumn(
            'message',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'message'
        );

        $table_smsglobal_sms_smslog->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'status'
        );

        $table_smsglobal_sms_smslog->addColumn(
            'msg_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'msg_id'
        );

        $table_smsglobal_sms_smslog->addColumn(
            'trigger',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'trigger'
        );

        $setup->getConnection()->createTable($table_smsglobal_sms_smslog);
    }
}