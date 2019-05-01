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


class OrderSaveAfter implements \Magento\Framework\Event\ObserverInterface
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
        $destination = null;
        $flag = false;
        $order = $observer->getEvent()->getOrder()->getData();
        $orderId = $order['increment_id'];
        $state = $order['state'];
        $this->_logger->info('Order ID (state) & Order:', [$orderId, $state, $order]);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderObj = $objectManager->get('Magento\Sales\Model\Order');
        $orderInformation = $orderObj->loadByIncrementId($orderId);
        if ($orderInformation->getShippingAddress()) {
            $destination = $orderInformation->getShippingAddress()->getTelephone();
        } else {
            foreach ($order['addresses'] as $addr) {
                if ($addr['telephone'] !== null) {
                    $destination = $addr['telephone'];
                }
            }
        }
        if ($destination) {
            if ($state == "new" && $this->_smsHelper->getNewOrderSmsEnabled()) {
                $this->_logger->info('New order SMS Initiated', [$order]);
                $trigger = "New Order";
                $origin = $this->_smsHelper->getNewOrderSmsSenderId();
                $message = $this->_smsHelper->getNewOrderSmsText();
                $adminNotify = $this->_smsHelper->getNewOrderSmsAdminNotifyEnabled();
                $flag = true;
            }
            if ($state == "holded" && $this->_smsHelper->getOrderHoldSmsEnabled()) {
                $this->_logger->info('hold order SMS Initiated', [$order]);
                $trigger = "Hold Order";
                $origin = $this->_smsHelper->getOrderHoldSmsSenderId();
                $message = $this->_smsHelper->getOrderHoldSmsText();
                $adminNotify = $this->_smsHelper->getOrderHoldSmsAdminNotifyEnabled();
                $flag = true;
            }
            if (strpos($_SERVER['REQUEST_URI'], 'order/unhold') !== false && $this->_smsHelper->getOrderUnholdSmsEnabled()) {
                $this->_logger->info('unhold order SMS Initiated', [$order]);
                $trigger = "Unhold Order";
                $origin = $this->_smsHelper->getOrderUnholdSmsSenderId();
                $message = $this->_smsHelper->getOrderUnholdSmsText();
                $adminNotify = $this->_smsHelper->getOrderUnholdSmsAdminNotifyEnabled();
                $flag = true;
            }
            if ($flag) {
                $data = $this->_smsHelper->getOrderData($orderInformation);
                $data['CustomerTelephone'] = $destination;
                $message = $this->_smsHelper->messageProcessor($message, $data);
                $this->_smsHelper->sendSms($origin, $destination, $message, null, $trigger, $adminNotify);
            }
        }
    }
}
