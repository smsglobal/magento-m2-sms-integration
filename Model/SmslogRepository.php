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

use Smsglobal\Sms\Api\SmslogRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Smsglobal\Sms\Model\ResourceModel\Smslog\CollectionFactory as SmslogCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Smsglobal\Sms\Api\Data\SmslogSearchResultsInterfaceFactory;
use Smsglobal\Sms\Api\Data\SmslogInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\DataObjectHelper;
use Smsglobal\Sms\Model\ResourceModel\Smslog as ResourceSmslog;

class SmslogRepository implements SmslogRepositoryInterface
{

    protected $resource;

    protected $searchResultsFactory;

    private $storeManager;

    protected $dataSmslogFactory;

    protected $smslogCollectionFactory;

    protected $smslogFactory;

    protected $dataObjectHelper;

    protected $extensionAttributesJoinProcessor;

    protected $dataObjectProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceSmslog $resource
     * @param SmslogFactory $smslogFactory
     * @param SmslogInterfaceFactory $dataSmslogFactory
     * @param SmslogCollectionFactory $smslogCollectionFactory
     * @param SmslogSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSmslog $resource,
        SmslogFactory $smslogFactory,
        SmslogInterfaceFactory $dataSmslogFactory,
        SmslogCollectionFactory $smslogCollectionFactory,
        SmslogSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->smslogFactory = $smslogFactory;
        $this->smslogCollectionFactory = $smslogCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSmslogFactory = $dataSmslogFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Smsglobal\Sms\Api\Data\SmslogInterface $smslog
    ) {
        /* if (empty($smslog->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $smslog->setStoreId($storeId);
        } */
        
        $smslogData = $this->extensibleDataObjectConverter->toNestedArray(
            $smslog,
            [],
            \Smsglobal\Sms\Api\Data\SmslogInterface::class
        );
        
        $smslogModel = $this->smslogFactory->create()->setData($smslogData);
        
        try {
            $this->resource->save($smslogModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the smslog: %1',
                $exception->getMessage()
            ));
        }
        return $smslogModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($logId)
    {
        $smslog = $this->smslogFactory->create();
        $this->resource->load($smslog, $logId);
        if (!$smslog->getId()) {
            throw new NoSuchEntityException(__('Smslog with id "%1" does not exist.', $logId));
        }
        return $smslog->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->smslogCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Smsglobal\Sms\Api\Data\SmslogInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Smsglobal\Sms\Api\Data\SmslogInterface $smslog
    ) {
        try {
            $smslogModel = $this->smslogFactory->create();
            $this->resource->load($smslogModel, $smslog->getlogId());
            $this->resource->delete($smslogModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Smslog: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($logId)
    {
        return $this->delete($this->getById($logId));
    }
}
