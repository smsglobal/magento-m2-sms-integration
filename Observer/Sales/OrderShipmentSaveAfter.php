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

class OrderShipmentSaveAfter implements \Magento\Framework\Event\ObserverInterface
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
        if ($this->_smsHelper->getNewShipmentSmsEnabled()) {

            $shipment = $observer->getEvent()->getShipment()->getData();
            $this->_logger->info('Shipment', [$shipment]);
            $orderId = $shipment['order_id'];
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);
            $destination = $order->getShippingAddress()->getTelephone();
            $this->_logger->info('Customer Mobile:', [$destination]);

            if ($destination) {
                if ($shipment['created_at'] == $shipment['updated_at']) {
                    $this->_logger->info('New Shipment SMS Initiated', [$orderId]);
                    $trigger = "New Shipment";
                    $origin = $this->_smsHelper->getNewShipmentSmsSenderId();
                    $message = $this->_smsHelper->getNewShipmentSmsText();
                    $adminNotify = $this->_smsHelper->getNewShipmentSmsAdminNotifyEnabled();
                } else {
                    $this->_logger->info('Update Shipment SMS Initiated', [$orderId]);
                    $trigger = "Shipment Updates";
                    $origin = $this->_smsHelper->getShipmentUpdatesSmsSenderId();
                    $message = $this->_smsHelper->getShipmentUpdatesSmsText();
                    $adminNotify = $this->_smsHelper->getShipmentUpdatesSmsAdminNotifyEnabled();
                }
                $data = $this->_smsHelper->getOrderData($order);
                $data = array_merge($data, $this->_smsHelper->getShipmentData($order,$observer->getEvent()->getShipment()));
                $data['CustomerTelephone'] = $destination;
                $message = $this->_smsHelper->messageProcessor($message, $data);
                $this->_smsHelper->sendSms($origin, $destination, $message, null, $trigger, $adminNotify);
            }
        }
    }
}
