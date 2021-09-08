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

namespace Smsglobal\Sms\Model\ResourceModel\Smslog;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'log_id';


    /**
     * @inheritdoc
     */
    protected function _initSelect()
    {
        $this->addFilterToMap('trigger', 'main_table.trigger');
        parent::_initSelect();
        return $this;
    }
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Smsglobal\Sms\Model\Smslog::class,
            \Smsglobal\Sms\Model\ResourceModel\Smslog::class
        );
    }
}
