<?php

namespace Smsglobal\Sms\Controller\Adminhtml\Smslog;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Eav\Model\Entity\Collection\AbstractCollection;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Controller\Adminhtml\Index\AbstractMassAction;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;

class BulkSend extends AbstractMassAction
{
    /**
     * @var Filter
     */
    protected $filter;


    protected $customerRepository;

    protected $_smsHelper;
    protected $_logger;


    protected function massAction(AbstractCollection $collection)
    {
        $data = [];
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $customer) {
            $data['id'][] = $customer->getId();
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('sms/bulksend', ['_query' => $data]);
    }

    public function __construct(
        Context $context,
        Filter $filter,

        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepository
    )
    {
        parent::__construct($context, $filter, $collectionFactory);
        $this->customerRepository = $customerRepository;
    }

}