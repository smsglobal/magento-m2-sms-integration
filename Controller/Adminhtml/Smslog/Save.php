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

namespace Smsglobal\Sms\Controller\Adminhtml\Smslog;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $smsHelper;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Smsglobal\Sms\Helper\Sms $smsHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Smsglobal\Sms\Helper\Sms $smsHelper
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->smsHelper = $smsHelper;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('log_id');

            $model = $this->_objectManager->create(\Smsglobal\Sms\Model\Smslog::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Smslog no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            try {
                $output = $this->smsHelper->sendSms($data['origin'], $data['destination'], $data['message'], $data['msg_date']);
                $this->messageManager->addSuccessMessage(__('SMS Sent'));
                $this->dataPersistor->clear('smsglobal_smslog');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['log_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while sending SMS'));
            }

            $this->dataPersistor->set('smsglobal_smslog', $data);
            return $resultRedirect->setPath('*/*/edit', ['log_id' => $this->getRequest()->getParam('log_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
