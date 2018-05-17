<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/14/2018
 * Time: 8:53 PM
 */

namespace Safaricom\Mpesa\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Stkpush extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('safaricom_mpesa_stkpush', 'stk_id');
    }
}