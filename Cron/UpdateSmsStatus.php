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

namespace Smsglobal\Sms\Cron;

use Smsglobal\Sms\Logger\Logger as Logger;


class UpdateSmsStatus
{

    protected $logger;
    protected $smslogFactory;
    protected $smsHelper;

    /**
     * Constructor
     *
     * @param Logger $logger
     * @param \Smsglobal\Sms\Model\ResourceModel\Smslog\CollectionFactory $smslogFactory
     * @param \Smsglobal\Sms\Helper\Sms $smsHelper
     */
    public function __construct(\Smsglobal\Sms\Helper\Sms $smsHelper, Logger $logger, \Smsglobal\Sms\Model\ResourceModel\Smslog\CollectionFactory $smslogFactory)
    {
        $this->logger = $logger;
        $this->smslogFactory = $smslogFactory;
        $this->smsHelper = $smsHelper;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->info('Smsglobal Cron Initiated', []);
        $smslogObj = $this->smslogFactory->create();
        $smslogCollection = $smslogObj->addFieldToFilter('status', array('eq' => 'Pending', 'eq' => 'Processing'));
        foreach ($smslogCollection as $smslog) {
            $messageId = $smslog->getMsgId();
            $status = $this->smsHelper->getSmsStatus($messageId);
            $this->logger->info('Smsglobal Cron Initiated', [$status]);
            if ($status) {
                $smslog->setStatus($status);
                $smslog->save();
            }
        }
    }
}
