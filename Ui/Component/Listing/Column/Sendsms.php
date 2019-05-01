<?php
namespace Smsglobal\Sms\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Sendsms extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$fieldName . '_html'] = "<button class='button'><span>SMS</span></button>";
                $item[$fieldName . '_title'] = __('Send SMS to Customer');
                $item[$fieldName . '_submitlabel'] = __('Send');
                $item[$fieldName . '_cancellabel'] = __('Reset');
                $item[$fieldName . '_customerid'] = $item['entity_id'];

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                $key_form = $objectManager->get('Magento\Framework\Data\Form\FormKey');
                $item[$fieldName . '_formkey'] =  $key_form->getFormKey();


                $item[$fieldName . '_formaction'] = $this->urlBuilder->getUrl('smsglobal_sms/smslog/sendSMS');
            }
        }

        return $dataSource;
    }
}