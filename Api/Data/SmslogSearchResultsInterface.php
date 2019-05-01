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

namespace Smsglobal\Sms\Api\Data;

interface SmslogSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Smslog list.
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface[]
     */
    public function getItems();

    /**
     * Set log_id list.
     * @param \Smsglobal\Sms\Api\Data\SmslogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
