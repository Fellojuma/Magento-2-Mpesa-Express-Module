<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/3/2018
 * Time: 11:33 PM
 */


namespace Safaricom\Mpesa\Observer;

use \Safaricom\Mpesa\Model\Mpesac2b;

class Payment implements \Magento\Framework\Event\ObserverInterface
{
    protected $_mpesa;

    public function __construct(
        Mpesac2b $mpesa,
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\DB\Transaction $transaction)
    {
        $this->_mpesa = $mpesa;
        $this->_invoiceService = $invoiceService;
        $this->_transaction = $transaction;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getData('order');
        if($order->getPayment()->getMethod()=='mpesac2b') {

            $record = $this->_mpesa->load($order->getQuoteId(), 'bill_ref_number');
            $record->setOrderAmount($order->getGrandTotal());
            $record->setOrderId($order->getIncrementId());
            $record->save();

            $order->setState('processing');
            $order->setStatus('processing');
            $order->save();

            $invoice = $this->_invoiceService->prepareInvoice($order);
            $invoice->register();
            $invoice->save();
            $transactionSave = $this->_transaction->addObject(
                $invoice
            )->addObject(
                $invoice->getOrder()
            );
            $transactionSave->save();
            //$this->invoiceSender->send($invoice);
            //send notification code

            
            $order->addStatusHistoryComment(
                __('Notified customer about invoice #%1.', $invoice->getId())
            )
                ->setIsCustomerNotified(true)
                ->save();

        }
    }
}