<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/26/2018
 * Time: 10:54 PM
 */

namespace Safaricom\Mpesa\Model;


class Mpesac2bConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{

    protected $methodCode = \Safaricom\Mpesa\Model\Mpesac2b::PAYMENT_METHOD_MPESAC2B_CODE;

    protected $escaper;

    protected $customerSession;

    public function __construct(
        \Magento\Payment\Helper\Data $paymentHelper,
        \Magento\Framework\Escaper $escaper,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->escaper = $escaper;
        $this->cart = $cart;
        $this->method = $paymentHelper->getMethodInstance($this->methodCode);
        $this->customerSession = $customerSession;
    }

    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                $this->methodCode => [
                    'customerName' => $this->getCustomerName(),
                    'customerPhone' => $this->getCustomerPhone(),
                    'paybillCurrency' => $this->getCurrency(),
                    'paybillWait' => 'safaricommpesa/mpesa/confirmpayment',
                    'paybillValidate' => 'safaricommpesa/mpesa/startpayment',
                    'paybillComplete' => 'safaricommpesa/mpesa/complete',
                    'payReference' => $this->getPayQouteId(),
                    'paybillNo' => $this->getPayPaybill(),
                    'mpesaLimit' => 70000,
                ],
            ],
        ] : [];
    }

    protected function getCustomerName()
    {
        return $this->customerSession->getCustomer()->getName();
    }

    protected function getCustomerId()
    {
        return $this->customerSession->getCustomer()->getId();
    }

    protected function getCustomerPhone()
    {
        //return $this->customerSession->getCustomer()->getPrimaryBillingAddress()->getTelephone();
    }

    protected function getCurrency()
    {
        /*
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $currencysymbol = $objectManager->get('Magento\Directory\Model\Currency');
        return $currencysymbol->getCurrencySymbol();
        */
        return 'KES';
    }

    protected function getPayQouteId()
    {
        return $this->cart->getQuote()->getId();
    }

    protected function getPayPaybill()
    {
        return $this->method->getPayPaybill();
    }
}