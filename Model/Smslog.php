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

namespace Smsglobal\Sms\Model;

use Smsglobal\Sms\Api\Data\SmslogInterface;
use Smsglobal\Sms\Api\Data\SmslogInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Smslog extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'smsglobal_sms_smslog';
    protected $dataObjectHelper;

    protected $smslogDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SmslogInterfaceFactory $smslogDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Smsglobal\Sms\Model\ResourceModel\Smslog $resource
     * @param \Smsglobal\Sms\Model\ResourceModel\Smslog\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SmslogInterfaceFactory $smslogDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Smsglobal\Sms\Model\ResourceModel\Smslog $resource,
        \Smsglobal\Sms\Model\ResourceModel\Smslog\Collection $resourceCollection,
        array $data = []
    ) {
        $this->smslogDataFactory = $smslogDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve smslog model with smslog data
     * @return SmslogInterface
     */
    public function getDataModel()
    {
        $smslogData = $this->getData();
        
        $smslogDataObject = $this->smslogDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $smslogDataObject,
            $smslogData,
            SmslogInterface::class
        );
        
        return $smslogDataObject;
    }
}
