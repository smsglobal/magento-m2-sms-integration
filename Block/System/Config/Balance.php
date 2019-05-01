<?php
namespace Smsglobal\Sms\Block\System\Config;
class Balance extends \Magento\Config\Block\System\Config\Form\Field
{
    protected $_template = 'Smsglobal_Sms::system/config/balance.phtml';
    protected $smsHelper; 

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Smsglobal\Sms\Helper\Sms $smsHelper
    ) {
        $this->smsHelper = $smsHelper;
        parent::__construct($context);
    }

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }

    public function getButtonHtml()
    {
        return $this->smsHelper->getBalance();
    }
}
