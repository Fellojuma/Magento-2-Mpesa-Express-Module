<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/26/2018
 * Time: 10:51 PM
 */

namespace Safaricom\Mpesa\Controller\Mpesa;

use Magento\Framework\App\Action\Context;

class Confirmation extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        Context $context
    )
    {

        parent::__construct($context);
    }


    public function execute()
    {
        $entityBody = trim(file_get_contents("php://input"));

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/confirm.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $splunk = (string)$entityBody;
        $logger->info('confirm:- ' . $splunk);
    }
}