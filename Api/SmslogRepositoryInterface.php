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

namespace Smsglobal\Sms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SmslogRepositoryInterface
{

    /**
     * Save Smslog
     * @param \Smsglobal\Sms\Api\Data\SmslogInterface $smslog
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Smsglobal\Sms\Api\Data\SmslogInterface $smslog
    );

    /**
     * Retrieve Smslog
     * @param string $logId
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($logId);

    /**
     * Retrieve Smslog matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Smsglobal\Sms\Api\Data\SmslogSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Smslog
     * @param \Smsglobal\Sms\Api\Data\SmslogInterface $smslog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Smsglobal\Sms\Api\Data\SmslogInterface $smslog
    );

    /**
     * Delete Smslog by ID
     * @param string $logId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($logId);
}
