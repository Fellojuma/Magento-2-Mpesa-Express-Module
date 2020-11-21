<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/14/2018
 * Time: 8:31 PM
 */

namespace Safaricom\Mpesa\Controller\Mpesa;


class Startpayment extends \Magento\Framework\App\Action\Action
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Safaricom\Mpesa\Model\Mpesac2b $mpesa,
        \Magento\Checkout\Model\Cart $cart,
        \Safaricom\Mpesa\Helper\Data $mpesahelper,
        \Safaricom\Mpesa\Model\Stkpush $stkpush
    )
    {
        $this->_stkpush = $stkpush;
        $this->_mpesa = $mpesa;
        $this->cart = $cart;
        $this->_mpesahelper = $mpesahelper;
        parent::__construct($context);
    }


    public function execute()
    {
        $phone = $this->getRequest()->getParam('phone');
       // $phone = '254720108418';

        $token = $this->_mpesahelper->generateToken();
        // $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        // $url = $this->_mpesahelper->getGeneralConfig('mpesa_request_url');

        if($this->_mpesahelper->getGeneralConfig('live_or_dev')){
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }
        else{
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$token)); //setting custom header

        $passkey = $this->_mpesahelper->getGeneralConfig('passkey');
        $paybill = $this->_mpesahelper->getGeneralConfig('my_paybill');


        date_default_timezone_set('Africa/Nairobi');
        $date = new \DateTime('now');
        $date->setTimezone(new \DateTimeZone('UTC'));
        $str_server_now = $date->format('YmdHis');
        date_default_timezone_set('UTC');
        $timestamp =  $str_server_now;

        $amount = $this->cart->getQuote()->getGrandTotal();
        $account_id = $this->cart->getQuote()->getId();
        $customerId = $this->cart->getQuote()->getCustomer()->getId();


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $paybill,
            'Password' => base64_encode($paybill.$passkey.$timestamp),
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => number_format($amount,0, '.', ''),
            'PartyA' =>  $this->_mpesahelper->formatPhone($phone),
            'PartyB' => $paybill,
            'PhoneNumber' => $this->_mpesahelper->formatPhone($phone),
            'CallBackURL' => $this->_url->getUrl('safaricommpesa/mpesa/stkpushlistener'),
            //'CallBackURL' => 'http://45.56.114.100/safaricommpesa/mpesa/stkpushlistener',
            'AccountReference' => $account_id,
            'TransactionDesc' => 'Magento Order'
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        $json = json_decode($curl_response,true);
        if(isset($json['errorCode']))
        {
            echo json_encode(['success'=>false,'message'=>$json['errorMessage']]);
        }
        elseif(isset($json['ResponseCode'])){
            //return json_encode(['success'=>true,'message'=>$json['ResponseDescription']]);
            $this->_stkpush->setData(['account_id'=>$account_id,'merchant_request_id'=>$json['MerchantRequestID'],'checkout_request_id'=>$json['CheckoutRequestID'],'phone'=>$phone,'customer_id'=>$customerId])->save();
            echo json_encode(['success'=>true,'message'=>$json['CustomerMessage'],'m_id'=>$json['MerchantRequestID'],'c_id' =>$json['CheckoutRequestID']]);
        }

    }
}
