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
    protected $smsHelper;
    protected $logger;


    public function __construct(\Smsglobal\Sms\Helper\Sms $smsHelper, Logger $logger
    )
    {
        $this->smsHelper = $smsHelper;
        $this->logger = $logger;
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
        if ($this->smsHelper->getOrderPaidSmsEnabled()) {

            /** @var \Magento\Sales\Model\Order\Invoice $invoice */
            $invoice = $observer->getEvent()->getInvoice();
            $this->logger->info('Invoice data', $invoice->getData());
            $order = $invoice->getOrder();
            $this->logger->info('Order data', $order->getData());
            $orderId = $invoice->getOrder()->getIncrementId();
            $this->logger->info('Order Paid SMS Initiated', [$orderId]);


            $address = $order->getShippingAddress() ?? $order->getBillingAddress();

            if (($address instanceof \Magento\Sales\Model\Order\Address) === false) {
                $this->logger->info("Billing/Shipping address not found");

                return;
            }

            $destination = $address->getTelephone();

            if (!empty($destination)) {
                $this->logger->info('Customer Mobile:', [$destination]);
                $origin = $this->smsHelper->getOrderPaidSmsSenderId();
                $message = $this->smsHelper->getOrderPaidSmsText();
                $adminNotify = $this->smsHelper->getOrderPaidSmsAdminNotifyEnabled();
                $trigger = "Order Paid";
                $data = $this->smsHelper->getOrderData($order);
                $data['CustomerTelephone'] = $destination;
                $extraData = $this->smsHelper->getInvoiceData($order);
                $data = array_merge($data, $extraData);
                $message = $this->smsHelper->messageProcessor($message, $data);
                $this->smsHelper->sendSms($origin, $destination, $message, null, $trigger, $adminNotify);
            }

        }
    }
}
