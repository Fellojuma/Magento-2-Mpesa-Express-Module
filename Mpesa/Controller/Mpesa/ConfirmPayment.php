<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/26/2018
 * Time: 10:42 PM
 */

namespace Safaricom\Mpesa\Controller\Mpesa;

use \Magento\Framework\App\Action\Context;
use \Safaricom\Mpesa\Model\Mpesac2b;
use \Safaricom\Mpesa\Model\Mpesac2bFactory;
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Safaricom\Mpesa\Model\Stkpush;

class ConfirmPayment extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Mpesac2b $mpesa,
        \Safaricom\Mpesa\Model\Stkpush $stkpush,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Safaricom\Mpesa\Helper\Data $mpesadata,
        Mpesac2bFactory $mpesaFactory
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_mpesa = $mpesa;
        $this->cart = $cart;
        $this->_stkpush = $stkpush;
        $this->_mpesadata = $mpesadata;
        $this->catalogSession = $catalogSession;
        $this->checkoutSession = $checkoutSession;
        $this->_mpesaFactory = $mpesaFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $amount = $this->cart->getQuote()->getGrandTotal();
        $ref = $this->cart->getQuote()->getId();

        $m_id = $this->getRequest()->getParam('m_id');
        $c_id = $this->getRequest()->getParam('c_id');
        $code = null;
        $success = false;
        $message = 'Waiting for transaction';
/*
        $collection = $this->_stkpush->getCollection()->addFieldToFilter('merchant_request_id',['eq'=>$m_id])
            ->addFieldToFilter('checkout_request_id',['eq'=>$c_id])
            ->addFieldToFilter('result_desc',['neq' => 'NULL']);

        if($collection)
        {
            foreach($collection as $record) {
                !empty($record->getResultCode()) ? $success = true : $success = false;
                $record->getResultCode() ==0 ? $code = 'O' : $code = $record->getResultCode();
                !empty ($record->getResultDesc()) ?  $message = $record->getResultDesc() : $message= 'Waiting for transaction';
                $record->setStatus(1);
                $record->save();
                $success = true;
            }
        }
*/
        $record = $this->_stkpush->load($m_id,'merchant_request_id');
        if(!empty($record->getResultDesc()))
        {
            $record->getResultCode() ==0 ? $code = 'O' : $code = $record->getResultCode();
            !empty ($record->getResultDesc()) ?  $message = $record->getResultDesc() : $message= 'Waiting for transaction';
            $record->setStatus(1);
            $record->save();
            $success = true;
        }
        echo json_encode(['success'=>$success,'message'=>$message,'code'=>$code]);

    }
}