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

namespace Smsglobal\Sms\Observer\Customer;

use Smsglobal\Sms\Logger\Logger as Logger;

class RegisterSuccess implements \Magento\Framework\Event\ObserverInterface
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
        if ($this->_smsHelper->getNewCustomerSmsEnabled()) {
            $customer = $observer->getEvent()->getCustomer();
            $this->_logger->info('Customer:', [$customer->getFirstName()]);

            if ($customer instanceof \Magento\Customer\Api\Data\CustomerInterface) {
                $addresses = $customer->getAddresses();

                foreach ($addresses as $address) {
                    if ($address->isDefaultBilling()) {
                        $billingAddress = $address;
                    }
                }
            }

            if (isset($billingAddress) && $billingAddress instanceof \Magento\Customer\Model\Data\Address) {
                $destination = $billingAddress->getTelephone();

                if (empty($destination)) {
                    $this->_logger->info('Customer does not have phone number associated to his billing address #' . $billingAddress->getId());
                }

                $data = $this->_smsHelper->getCustomerData($customer);
                $this->_logger->info('New Customer SMS Initiated', [$customer->getFirstName()]);
                $trigger = "New Customer";
                $origin = $this->_smsHelper->getNewCustomerSmsSenderId();
                $message = $this->_smsHelper->getNewCustomerSmsText();
                $message = $this->_smsHelper->messageProcessor($message, $data);
                $adminNotify = $this->_smsHelper->getNewCustomerSmsAdminNotifyEnabled();
                $this->_smsHelper->sendSms($origin, $destination, $message, null, $trigger, $adminNotify);
            } else {
                $this->_logger->info("Billing address not found");
            }
        }
    }
}