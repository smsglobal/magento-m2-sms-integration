<?php

namespace Smsglobal\Sms\Block\Adminhtml\BulkSend;


class Index extends \Magento\Backend\Block\Template
{
    /**
     * @var $request
     */
    protected $request;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;


    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = []
    )
    {
        $this->request = $context->getRequest();
        $this->urlBuilder = $context->getUrlBuilder();
        parent::__construct($context, $data);
    }

    public function getFormUrl()
    {
        return $this->urlBuilder->getUrl('smsglobal_sms/smslog/sendSMS');
    }

    public function getFormKey()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $key_form = $objectManager->get('Magento\Framework\Data\Form\FormKey');
        return $key_form->getFormKey();
    }

    public function getCustomerParams()
    {
        $data = [];
        $postData = $this->request->getParam('id');

        foreach ($postData as $id) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
            $customer = $customerFactory->create();
            $cust = $customer->load($id);
            $data[$id]['name'] = $cust->getName();
            $data[$id]['phone'] = $cust->getDefaultBillingAddress() ? $cust->getDefaultBillingAddress()->getTelephone() : ($cust->getDefaultShippingAddress() ? $cust->getDefaultShippingAddress()->getTelephone() : null);
        }
        return $data;
    }

}