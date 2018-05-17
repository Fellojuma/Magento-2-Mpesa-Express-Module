<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 1/27/2018
 * Time: 9:45 AM
 */

namespace Safaricom\Mpesa\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Mpesac2b extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('safaricom_mpesa_c2b', 'mpesa_id');
    }
}