<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/26/2018
 * Time: 11:33 PM
 */
namespace Safaricom\Mpesa\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected $storeManager;
    protected $objectManager;

    const XML_PATH_SAFARICOM_MPESA = 'payment/mpesac2b/';



    public function __construct(Context $context,
                                ObjectManagerInterface $objectManager,
                                StoreManagerInterface $storeManager
    ) {
        $this->objectManager = $objectManager;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }


    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_SAFARICOM_MPESA . $code, $storeId);
    }

    public function generateToken()
    {

        $credentials = base64_encode($this->getGeneralConfig('consumer_key').':'.$this->getGeneralConfig('consumer_secret'));
        //$url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';        
        if($this->getGeneralConfig('live_or_dev')){
            $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        }
        else{
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        $data = json_decode($curl_response,true);
        curl_close($curl);
        //var_dump($curl_response);
        return $data['access_token'];

    }

    public function c2bRequest($amount,$ref)
    {

    }

    public function formatPhone($phone)
    {
        $phone = str_replace (' ', '',trim($phone));
        return "254".substr($phone, -9);
    }

}
