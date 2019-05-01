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

interface SmslogInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const TRIGGER = 'trigger';
    const MSG_DATE = 'msg_date';
    const MSG_ID = 'msg_id';
    const ORIGIN = 'origin';
    const STATUS = 'status';
    const DESTINATION = 'destination';
    const MESSAGE = 'message';
    const LOG_ID = 'log_id';

    /**
     * Get log_id
     * @return string|null
     */
    public function getlogId();

    /**
     * Set log_id
     * @param string $logId
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setlogId($logId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Smsglobal\Sms\Api\Data\SmslogExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Smsglobal\Sms\Api\Data\SmslogExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Smsglobal\Sms\Api\Data\SmslogExtensionInterface $extensionAttributes
    );

    /**
     * Get msg_date
     * @return string|null
     */
    public function getMsgDate();

    /**
     * Set msg_date
     * @param string $msgDate
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setMsgDate($msgDate);

    /**
     * Get origin
     * @return string|null
     */
    public function getOrigin();

    /**
     * Set origin
     * @param string $origin
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setOrigin($origin);

    /**
     * Get destination
     * @return string|null
     */
    public function getDestination();

    /**
     * Set destination
     * @param string $destination
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setDestination($destination);

    /**
     * Get message
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     * @param string $message
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setMessage($message);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setStatus($status);

    /**
     * Get msg_id
     * @return string|null
     */
    public function getMsgId();

    /**
     * Set msg_id
     * @param string $msgId
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setMsgId($msgId);

    /**
     * Get Trigger
     * @return string|null
     */
    public function getTrigger();

    /**
     * Set Trigger
     * @param string $trigger
     * @return \Smsglobal\Sms\Api\Data\SmslogInterface
     */
    public function setTrigger($trigger);
}
