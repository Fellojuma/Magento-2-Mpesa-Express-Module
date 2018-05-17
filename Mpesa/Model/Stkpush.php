<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/14/2018
 * Time: 8:50 PM
 */

namespace Safaricom\Mpesa\Model;

class Stkpush extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('Safaricom\Mpesa\Model\ResourceModel\Stkpush');
    }

}