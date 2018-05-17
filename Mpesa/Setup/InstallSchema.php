<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/27/2018
 * Time: 9:47 AM
 */

namespace Safaricom\Mpesa\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Get mpesa_paybill table
        $tableName = $installer->getTable('safaricom_mpesa_c2b');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create mpesa_paybill table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'mpesa_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'uns
                        igned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Mpesa ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Customer ID'
                )
                ->addColumn(
                    'customer_phone',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Customer Phone'
                )
                ->addColumn(
                    'order_amount',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Order Amount'
                )
                ->addColumn(
                    'order_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Order ID'
                )
                ->addColumn(
                    'trans_type',
                    Table::TYPE_TEXT,
                    '2M',
                    ['nullable' => false, 'default' => ''],
                    'Transaction Type'
                )
                ->addColumn(
                    'trans_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Transaction ID'
                )
                ->addColumn(
                    'trans_time',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Transaction Time'
                )
                ->addColumn(
                    'trans_amount',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Transaction Amount'
                )
                ->addColumn(
                    'business_shortcode',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Business ShortCode'
                )
                ->addColumn(
                    'bill_ref_number',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Bill Ref Number'
                )
                ->addColumn(
                    'invoice_number',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Invoice Number'
                )
                ->addColumn(
                    'msisdn',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'MSISDN'
                )
                ->addColumn(
                    'customer_name',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Customer Name'
                )
                ->addColumn(
                    'callback_time',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Callback Time'
                )
                ->addColumn(
                    'request_time',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Request Time'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => '0'],
                    'Status'
                )
                ->setComment('Mpesa C2B Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }


        $tableName = $installer->getTable('safaricom_mpesa_stkpush');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create mpesa_paybill table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'stk_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'uns
                        igned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Stk ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Customer ID'
                )
                ->addColumn(
                    'merchant_request_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Merchant Request ID'
                )
                ->addColumn(
                    'checkout_request_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Checkout Request ID'
                )
                ->addColumn(
                    'response_code',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Response Code'
                )
                ->addColumn(
                    'customer_message',
                    Table::TYPE_TEXT,
                    '2M',
                    ['nullable' => false, 'default' => ''],
                    'Customer Message'
                )
                ->addColumn(
                    'trans_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Transaction ID'
                )
                ->addColumn(
                    'response_description',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Response Description'
                )
                ->addColumn(
                    'result_code',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Result Code'
                )
                ->addColumn(
                    'result_desc',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Result Desc'
                )
                ->addColumn(
                    'account_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Account Id'
                )
                ->addColumn(
                    'phone',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Phone'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Customer Id'
                )
                ->addColumn(
                    'customer_name',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false],
                    'Customer Name'
                )
                ->addColumn(
                    'callback_time',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Callback Time'
                )
                ->addColumn(
                    'request_time',
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => false],
                    'Request Time'
                )

                ->setComment('STK Push Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }


        $installer->endSetup();
    }


}