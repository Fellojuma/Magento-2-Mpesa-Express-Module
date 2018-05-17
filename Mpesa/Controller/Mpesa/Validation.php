<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/26/2018
 * Time: 10:50 PM
 */

namespace Safaricom\Mpesa\Controller\Mpesa;

use Magento\Framework\App\Action\Context;

class Validation extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        Context $context,
        \Safaricom\Mpesa\Model\Mpesac2b $mpesa
    )
    {
        $this->_mpesa = $mpesa;
        parent::__construct($context);
    }


    public function execute()
    {
        $entityBody = trim(file_get_contents("php://input"));

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/validation.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $splunk = (string)$entityBody;
        $logger->info('validation:- ' . $splunk);

        $result = json_decode($entityBody,true);
        $name = '';
        isset($result['FirstName']) ? $name .= $result['FirstName'].' ' : '';
        isset($result['MiddleName']) ? $name .= $result['MiddleName']. ' ' : '';
        isset($result['LastName']) ? $name .= $result['LastName'].' ' : '';

        $data = [
            'trans_id' => $result['TransID'],
            'trans_time' => $result['TransTime'],
            'trans_amount' => $result['TransAmount'],
            'business_shortcode' => $result['BusinessShortCode'],
            'bill_ref_number' => $result['BillRefNumber'],
            'invoice_number' => $result['InvoiceNumber'],
            'msisdn' => $result['MSISDN'],
            'customer_name' => $name
        ];

        $this->_mpesa->setData($data)->save();

        echo '{"ResultCode": 0, "ResultDesc": "The service was accepted successfully", "ThirdPartyTransID": "1234567890"}';

    }

}