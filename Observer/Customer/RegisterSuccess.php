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
        if ($this->smsHelper->getNewCustomerSmsEnabled()) {
            $customer = $observer->getEvent()->getCustomer();
            $this->logger->info('Customer:', [$customer->getFirstName()]);

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
                    $this->logger->info('Customer does not have phone number associated to his billing address #' . $billingAddress->getId());
                }

                $data = $this->smsHelper->getCustomerData($customer);
                $this->logger->info('New Customer SMS Initiated', [$customer->getFirstName()]);
                $trigger = "New Customer";
                $origin = $this->smsHelper->getNewCustomerSmsSenderId();
                $message = $this->smsHelper->getNewCustomerSmsText();
                $message = $this->smsHelper->messageProcessor($message, $data);
                $adminNotify = $this->smsHelper->getNewCustomerSmsAdminNotifyEnabled();
                $this->smsHelper->sendSms($origin, $destination, $message, null, $trigger, $adminNotify);
            } else {
                $this->logger->info("Billing address not found");
            }
        }
    }
}