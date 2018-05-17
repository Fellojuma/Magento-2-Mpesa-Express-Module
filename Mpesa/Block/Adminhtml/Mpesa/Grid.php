<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/3/2018
 * Time: 12:37 PM
 */

namespace Safaricom\Mpesa\Block\Adminhtml\Mpesa;

use \Magento\Backend\Block\Template\Context;
use \Magento\Backend\Helper\Data as HelperData;
use \Magento\Framework\Event\ManagerInterface;
use \Safaricom\Mpesa\Model\Mpesac2b;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var DropshipHelperData
     */
    protected $_hlp;

    public function __construct(
        Mpesac2b $mpesac2b,
        Context $context,
        HelperData $backendHelper,
        array $data = []
    )
    {
        $this->_mpesac2b = $mpesac2b;

        parent::__construct($context, $backendHelper, $data);
        $this->setId('mpesaGrid');
        $this->setDefaultSort('mpesa_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('mpesa_filter');
    }

    protected function _prepareCollection()
    {
        $collection = $this->_mpesac2b->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('mpesa_id', array(
            'header'    => __('Mpesa ID'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'mpesa_id',
            'type'      => 'number',
        ));

        $this->addColumn('customer_name', array(
            'header'    => __('Customer Name'),
            'index'     => 'customer_name',
        ));

        $this->addColumn('msisdn', array(
            'header'    => __('Phone Number'),
            'index'     => 'msisdn',
        ));

        $this->addColumn('trans_id', array(
            'header'    => __('Transaction Id'),
            'index'     => 'trans_id',
        ));

        $this->addColumn('trans_amount', array(
            'header'    => __('Transaction Amount'),
            'index'     => 'trans_amount',
        ));

        $this->addColumn('business_shortcode', array(
            'header'    => __('Paybill'),
            'index'     => 'business_shortcode',
        ));

        $this->addColumn('bill_ref_number', array(
            'header'    => __('Account'),
            'index'     => 'bill_ref_number',
        ));

        $this->addColumn('order_id', array(
            'header'    => __('Order ID'),
            'index'     => 'order_id',
        ));


        $this->addColumn('order_amount', array(
            'header'    => __('Order Amount'),
            'index'     => 'order_amount',
        ));


        $this->addColumn('trans_time', array(
            'header'    => __('Transaction Date'),
            'index'     => 'trans_time',
            'type'      => 'datetime',
            'width'     => 150,
        ));

        /*
        $this->addColumn('action',
            array(
                'header'    => __('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => __('View'),
                        'url'     => array('base'=>'mpesaadmin/mpesa/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true
        ));
        */

        $this->addExportType('*/*/exportCsv', __('CSV'));
        $this->addExportType('*/*/exportXml', __('XML'));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        //return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }


    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
