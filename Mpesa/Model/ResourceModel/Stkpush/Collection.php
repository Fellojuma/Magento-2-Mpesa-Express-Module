<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/3/2018
 * Time: 10:52 PM
 */

namespace Safaricom\Mpesa\Model\ResourceModel\Stkpush;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Safaricom\Mpesa\Model\Stkpush', 'Safaricom\Mpesa\Model\ResourceModel\Stkpush');
        parent::_construct();
    }

}