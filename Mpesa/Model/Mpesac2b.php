<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/26/2018
 * Time: 10:39 PM
 */

namespace Safaricom\Mpesa\Model;


class Mpesac2b extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment code
     *
     * @var string
     */
    const PAYMENT_METHOD_MPESAC2B_CODE = 'mpesac2b';

    protected $_code = self::PAYMENT_METHOD_MPESAC2B_CODE;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    protected function _construct()
    {
        $this->_init('Safaricom\Mpesa\Model\ResourceModel\Mpesac2b');
    }

    public function getPayPaybill()
    {
        return $this->getConfigData('my_paybill');
    }

}