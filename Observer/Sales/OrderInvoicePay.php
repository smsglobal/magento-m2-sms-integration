<?php
/**
 * SMSGlobal SMS Integration with Magento developed by SMSGlobal Team (Allam Praveen)
 * Copyright (C) 2018  SMSGlobal
 *
 * This file included in Smsglobal/Sms is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Smsglobal\Sms\Observer\Sales;

use Smsglobal\Sms\Logger\Logger as Logger;


class OrderInvoicePay implements \Magento\Framework\Event\ObserverInterface
{
    protected $_smsHelper;
    protected $_logger;


    public function __construct(\Smsglobal\Sms\Helper\Sms $smsHelper, Logger $logger
    )
    {
        $this->_smsHelper = $smsHelper;
        $this->_logger = $logger;
    }


    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    )
    {
        if ($this->_smsHelper->getOrderPaidSmsEnabled()) {

            /** @var \Magento\Sales\Model\Order\Invoice $invoice */
            $invoice = $observer->getEvent()->getInvoice();
            $this->_logger->info('Invoice data', $invoice->getData());
            $order = $invoice->getOrder();
            $this->_logger->info('Order data', $order->getData());
            $orderId = $invoice->getOrder()->getIncrementId();
            $this->_logger->info('Order Paid SMS Initiated', [$orderId]);

            if ($order->getShippingAddress()) {
                $destination = $order->getShippingAddress()->getTelephone();

                if (!empty($destination)) {
                    $this->_logger->info('Customer Mobile:', [$destination]);
                    $origin = $this->_smsHelper->getOrderPaidSmsSenderId();
                    $message = $this->_smsHelper->getOrderPaidSmsText();
                    $adminNotify = $this->_smsHelper->getOrderPaidSmsAdminNotifyEnabled();
                    $trigger = "Order Paid";
                    $data = $this->_smsHelper->getOrderData($order);
                    $data['CustomerTelephone'] = $destination;
                    $extraData = $this->_smsHelper->getInvoiceData($order);
                    $data = array_merge($data, $extraData);
                    $message = $this->_smsHelper->messageProcessor($message, $data);
                    $this->_smsHelper->sendSms($origin, $destination, $message, null, $trigger, $adminNotify);
                }
            }

        }
    }
}
