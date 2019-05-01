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

namespace Smsglobal\Sms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Smsglobal\Sms\Logger\Logger as Logger;

class Sms extends AbstractHelper
{

    protected $_objectInterface;
    protected $_objectManager;
    protected $_logger;

    /**
     * @var Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_timezoneInterface;

    const CHAR_MAP = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTWXYZ0123456789';

    public function __construct(Context $context, Logger $logger,\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface)
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->_objectInterface = $this->_objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface');
        $this->_logger = $logger;
        $this->_timezoneInterface = $timezoneInterface;
        parent::__construct($context);
    }

    /**
     * Returns API Key from Store Configuration
     * @return string
     */
    public
    function getApiKey()
    {
        return $this->_objectInterface->getValue('generalsettings/smsglobalsettings/apikey');
    }

    /**
     * Returns API URL from Store Configuration
     * @return string
     */
    public
    function getApiUrl()
    {
        return $this->_objectInterface->getValue('generalsettings/smsglobalsettings/apiurl');
    }

    /**
     * Returns Secret Key from Store Configuration
     * @return string
     */
    public
    function getSecretKey()
    {
        return $this->_objectInterface->getValue('generalsettings/smsglobalsettings/secretkey');
    }

    /**
     * Returns Sender ID from Store Configuration
     * @return string
     */
    public
    function getSenderId()
    {
        return $this->_objectInterface->getValue('generalsettings/smsglobalsettings/senderid');
    }

    /**
     * Returns Store Mobile Number from Store Configuration
     * @return string
     */
    public
    function getStoreMobileNumber()
    {
        return $this->_objectInterface->getValue('generalsettings/smsglobalsettings/storemobile');
    }

    /**
     * Returns Test SMS Text from Store Configuration
     * @return string
     */
    public
    function getTestSmsText()
    {
        return $this->_objectInterface->getValue('generalsettings/testsmssettings/testsmstext');
    }

    /**
     * Returns Test Mobile Number from Store Configuration
     * @return string
     */
    public
    function getTestMobileNumber()
    {
        return $this->_objectInterface->getValue('generalsettings/testsmssettings/testmobilenumber');
    }

    /**
     * Returns whether new customer sms is enabled or not
     * @return boolean
     */
    public function getNewCustomerSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/newcustomer/enabled');
    }

    /**
     * Returns New Customer SMS Text from Store Configuration
     * @return string
     */
    public function getNewCustomerSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/newcustomer/smstext');
    }

    /**
     * Returns whether new customer sms notification to admin is enabled or not
     * @return boolean
     */
    public function getNewCustomerSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/newcustomer/adminnotify');
    }

    /**
     * Returns New Customer SMS Sender Id from Store Configuration
     * @return string
     */
    public function getNewCustomerSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/newcustomer/senderid');
    }


    /**
     * Returns whether new order sms is enabled or not
     * @return boolean
     */
    public function getNewOrderSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/neworder/enabled');
    }

    /**
     * Returns New Order SMS Text from Store Configuration
     * @return string
     */
    public function getNewOrderSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/neworder/smstext');
    }

    /**
     * Returns whether new order sms notification to admin is enabled or not
     * @return boolean
     */
    public function getNewOrderSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/neworder/adminnotify');
    }

    /**
     * Returns New Order SMS Sender Id from Store Configuration
     * @return string
     */
    public function getNewOrderSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/neworder/senderid');
    }

    /**
     * Returns whether order paid  sms is enabled or not
     * @return boolean
     */
    public function getOrderPaidSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/orderpaid/enabled');
    }

    /**
     * Returns order paid  SMS Text from Store Configuration
     * @return string
     */
    public function getOrderPaidSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/orderpaid/smstext');
    }

    /**
     * Returns whether order paid  sms notification to admin is enabled or not
     * @return boolean
     */
    public function getOrderPaidSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/orderpaid/sendadmin');
    }

    /**
     * Returns order paid  SMS Sender Id from Store Configuration
     * @return string
     */
    public function getOrderPaidSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/orderpaid/senderid');
    }


    /**
     * Returns whether order refund sms is enabled or not
     * @return boolean
     */
    public function getRefundOrderSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/refundorder/senderid');
    }

    /**
     * Returns order refund SMS Text from Store Configuration
     * @return string
     */
    public function getRefundOrderSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/refundorder/smstext');
    }

    /**
     * Returns whether order refund  sms notification to admin is enabled or not
     * @return boolean
     */
    public function getRefundOrderSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/refundorder/adminnotify');
    }

    /**
     * Returns order refund SMS Sender Id from Store Configuration
     * @return string
     */
    public function getRefundOrderSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/refundorder/senderid');
    }

    /**
     * Returns whether order cancel sms is enabled or not
     * @return boolean
     */
    public function getCancelOrderSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/ordercancel/enabled');
    }

    /**
     * Returns order cancel SMS Text from Store Configuration
     * @return string
     */
    public function getCancelOrderSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/ordercancel/smstext');
    }

    /**
     * Returns whether order cancel sms notification to admin is enabled or not
     * @return boolean
     */
    public function getCancelOrderSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/ordercancel/adminnotify');
    }

    /**
     * Returns order cancel SMS Sender Id from Store Configuration
     * @return string
     */
    public function getCancelOrderSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/ordercancel/senderid');
    }

    /**
     * Returns whether new shipment sms is enabled or not
     * @return boolean
     */
    public function getNewShipmentSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/newshipment/enabled');
    }

    /**
     * Returns New Shipment SMS Text from Store Configuration
     * @return string
     */
    public function getNewShipmentSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/newshipment/smstext');
    }

    /**
     * Returns whether new shipment sms notification to admin is enabled or not
     * @return boolean
     */
    public function getNewShipmentSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/newshipment/adminnotify');
    }

    /**
     * Returns New Shipment SMS Sender Id from Store Configuration
     * @return string
     */
    public function getNewShipmentSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/newshipment/senderid');
    }

    /**
     * Returns whether shipment updates sms is enabled or not
     * @return boolean
     */
    public function getShipmentUpdatesSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/shipmentupdates/enabled');
    }

    /**
     * Returns Shipment Updates SMS Text from Store Configuration
     * @return string
     */
    public function getShipmentUpdatesSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/shipmentupdates/smstext');
    }

    /**
     * Returns whether shipment updates sms notification to admin is enabled or not
     * @return boolean
     */
    public function getShipmentUpdatesSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/shipmentupdates/adminnotify');
    }

    /**
     * Returns Shipment Updates SMS Sender Id from Store Configuration
     * @return string
     */
    public function getShipmentUpdatesSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/shipmentupdates/senderid');
    }

    /**
     * Returns whether hold order sms is enabled or not
     * @return boolean
     */
    public function getOrderHoldSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/orderhold/enabled');
    }

    /**
     * Returns hold order sms text from Store Configuration
     * @return string
     */
    public function getOrderHoldSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/orderhold/smstext');
    }

    /**
     * Returns whether hold order sms notification to admin is enabled or not
     * @return boolean
     */
    public function getOrderHoldSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/orderhold/adminnotify');
    }

    /**
     * Returns hold order SMS Sender Id from Store Configuration
     * @return string
     */
    public function getOrderHoldSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/orderhold/senderid');
    }

    /**
     * Returns whether unhold order sms is enabled or not
     * @return boolean
     */
    public function getOrderUnholdSmsEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/orderunhold/enabled');
    }

    /**
     * Returns unhold order sms text from Store Configuration
     * @return string
     */
    public function getOrderUnholdSmsText()
    {
        return $this->_objectInterface->getValue('smstriggers/orderunhold/smstext');
    }

    /**
     * Returns whether unhold order sms notification to admin is enabled or not
     * @return boolean
     */
    public function getOrderUnholdSmsAdminNotifyEnabled()
    {
        return $this->_objectInterface->getValue('smstriggers/orderunhold/adminnotify');
    }

    /**
     * Returns unhold order SMS Sender Id from Store Configuration
     * @return string
     */
    public function getOrderUnholdSmsSenderId()
    {
        return $this->_objectInterface->getValue('smstriggers/orderunhold/senderid');
    }


    /**
     * @param int $length
     *
     * @return string
     */
    public
    function createRandomString($length = 10)
    {
        $result = '';
        $size = strlen(self::CHAR_MAP);
        for ($i = 0; $i < $length; $i++) {
            $result .= self::CHAR_MAP[rand(0, $size - 1)];
        }

        return $result;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param string $host
     * @param int $port
     * @param string $extraData
     *
     * @return string
     */
    public
    function generateMacHeader($apikey, $secret, $method = 'POST', $uri = '/v2/sms/', $host = 'api.smsglobal.com', $port = 443, $extraData = '')
    {

        $timestamp = time();
        $nonce = $this->createRandomString();


        $rawString = $timestamp . "\n" . $nonce . "\n" . $method . "\n" . $uri . "\n" . $host . "\n" . $port . "\n" . $extraData . "\n";
        $hashHeader = base64_encode(hash_hmac('sha256', $rawString, $secret, true));

        return "MAC id=\"$apikey\", ts=\"$timestamp\", nonce=\"$nonce\", mac=\"$hashHeader\"";

    }

    /**
     * @param $origin
     * @param $destination
     * @param $message
     * @param null $messageDate
     * @param string $trigger
     * @param bool $adminNotify
     * @throws Exception
     * @return null
     */
    public
    function sendSms($origin, $destination, $message, $messageDate = null, $trigger = "Message", $adminNotify = false)
    {
        $apikey = $this->getApiKey();
        $secret = $this->getSecretKey();

        if ($apikey == '' && $secret == '') {
            return 'No API/Secret key Provided';
        }

        $mac = $this->generateMacHeader($apikey, $secret);

        $curlRequest = curl_init();
        curl_setopt($curlRequest, CURLOPT_URL, $this->getApiUrl());
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, [
            "Authorization: $mac",
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $origin = $origin ? $origin : $this->getSenderId();
        $destinationList = explode(",", $destination);

        $recipients = [];
        $recipients = array_merge($recipients, $destinationList);
        if ($adminNotify) {
            $storeNumber = $this->getStoreMobileNumber();
            $storeNumbers = explode(",", $storeNumber);
            $recipients = array_merge($recipients, $storeNumbers);
        }

        $data = [
            'origin' => $origin,
            'destinations' => $recipients,
            'message' => $message,
        ];
        if ($messageDate) {
            $data['scheduledDateTime'] = $this->datetimeconv($messageDate);
            $trigger = "Scheduled Message";
        }


        $productMetadata = $this->_objectManager->get('Magento\Framework\App\ProductMetadataInterface');
        $version = $productMetadata->getVersion();

        $agent = "SMSGlobal-Integrations/1.0, Magento-m2/" . $version;
        curl_setopt($curlRequest, CURLOPT_USERAGENT, $agent);
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlRequest, CURLOPT_POST, true);
        curl_setopt($curlRequest, CURLOPT_POSTFIELDS, json_encode($data));

        $output = curl_exec($curlRequest);

        if (curl_error($curlRequest)) {
            $this->_logger->addInfo("SMS:", [$output]);
            return;
        }

        curl_close($curlRequest);


        if ($output) {
            $results = json_decode($output);


            $this->_logger->addInfo("SMS:", [$results]); // log string Data to customfile.log

            if (property_exists($results, 'messages')) {

                foreach ($results->messages as $result) {
                    $data = [];
                    $data['msg_id'] = $result->outgoing_id;
                    $data['msg_date'] = property_exists($result, 'scheduledDatetime') ? $this->getTimeAccordingToTimeZone($result->scheduledDatetime) : $this->getTimeAccordingToTimeZone($result->dateTime);
                    $data['origin'] = $result->origin;
                    $data['destination'] = $result->destination;
                    $data['message'] = $result->message;
                    $data['status'] = $result->status;
                    $data['store_id'] = 1;
                    $data['trigger'] = $trigger;
                    $data['comment'] = $output;
                    $model = $this->_objectManager->create(\Smsglobal\Sms\Model\Smslog::class);
                    try {
                        $model->setData($data)->save();
                    } catch (\Exception $e) {
                        $this->_logger->addInfo("Error", [$e->getMessage()]);
                    }
                }
            }
        }

    }

    /**
     * @return string
     */
    public
    function getBalance()
    {
        $apikey = $this->getApiKey();
        $secret = $this->getSecretKey();

        if ($apikey == '' && $secret == '') {
            return 'No API/Secret key Provided';
        }

        $mac = $this->generateMacHeader($apikey, $secret, 'GET', '/v2/user/credit-balance');

        $curlRequest = curl_init();
        curl_setopt($curlRequest, CURLOPT_URL, 'https://api.smsglobal.com/v2/user/credit-balance');
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, [
            "Authorization: $mac",
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, true);
        if (curl_error($curlRequest)) {
            return 'Retry again';
        }

        $output = curl_exec($curlRequest);

        $this->_logger->addInfo("Balance:", [$output]);


        $result = json_decode($output);

        if ($result) {
            if (property_exists($result, 'status')) {
                return "Postpaid";
            } elseif (property_exists($result, 'code')) {
                return "Postpaid";
            } else {
                return "<strong>" . $result->currency . " " . $result->balance . "</strong>";
            }
        } else {
            return "<strong><font color='red'>" . $output . "</font></strong>";

        }
    }

    /**
     * @param $messageId
     *
     * @return string
     */
    public
    function getSmsStatus($messageId)
    {
        $apikey = $this->getApiKey();
        $secret = $this->getSecretKey();

        if ($apikey == '' && $secret == '') {
            return 'No API/Secret key Provided';
        }

        $mac = $this->generateMacHeader($apikey, $secret, 'GET', '/v2/sms/' . $messageId);

        $curlRequest = curl_init();
        curl_setopt($curlRequest, CURLOPT_URL, 'https://api.smsglobal.com/v2/sms/' . $messageId);
        curl_setopt($curlRequest, CURLOPT_HTTPHEADER, [
            "Authorization: $mac",
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, true);
        if (curl_error($curlRequest)) {
            return 'Retry again';
        }

        $output = curl_exec($curlRequest);
        $this->_logger->addInfo("Status:", [$output]);

        $result = json_decode($output);

        return $result->status;
    }

    /**
     * @param $message
     * @param $data
     *
     * @return string
     */
    public
    function messageProcessor($message, $data)
    {
        foreach ($data as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }

        return $message;
    }

    /**
     * @param $order
     *
     * @return array
     */
    public
    function getOrderData($order)
    {
        $data = [];
        $data['OrderNumber'] = $order->getIncrementId();
        $data['CustomerFirstName'] = $order->getCustomerFirstname();
        $data['CustomerLastName'] = $order->getCustomerLastname();
        $data['OrderTotal'] = number_format($order->getGrandTotal(), 2);
        $data['CustomerEmail'] = $order->getCustomerEmail();
        $data['OrderCurrency'] = $order->getOrderCurrencyCode();
        $data['OrderDate'] = date('F j, Y', strtotime($order->getCreatedAt()));
        $data['OrderTime'] = date('g:i a', strtotime($order->getCreatedAt()));
        $data['OrderStatus'] = $order->getStatus();

        return $data;
    }

    /**
     * @param $order
     * @param $shipment
     *
     * @return array
     */
    public
    function getShipmentData($order, $shipment)
    {
        $data = [];

        $tracksCollection = $shipment->getTracksCollection();

        foreach ($tracksCollection->getItems() as $track) {

            $data['TrackingNumber'] = $track->getTrackNumber();
            $data['Carrier'] = $track->getCarrierCode();

        }

        return $data;
    }

    /**
     * @param $order
     *
     * @return array
     */
    public
    function getInvoiceData($order)
    {
        $data = [];
        $data['PaymentMode'] = $order->getPayment()->getMethodInstance()->getCode();

        return $data;
    }

    /**
     * @param $customer
     *
     * @return array
     */
    public
    function getCustomerData($customer)
    {
        $data = [];
        $data['CustomerFirstName'] = $customer->getFirstname();
        $data['CustomerMiddleName'] = $customer->getMiddlename(); // Middle Name
        $data['CustomerLastName'] = $customer->getLastname(); // Middle Name
        $data['CustomerEmail'] = $customer->getEmail();

        return $data;
    }

    public
    function datetimeconv($datetime)
    {
        $datetime =  new \DateTime(str_replace('T', ' ', substr($datetime,0,-5)));
        $to = ['localeFormat' => "Y-m-d H:i:s", 'olsonZone' => 'UTC'];
        return $datetime->format($to['localeFormat']);
    }

    /**
     * @param string $dateTime
     * @return string $dateTime as time zone
     * @throws
     */
    public function getTimeAccordingToTimeZone($dateTime)
    {
        // for get current time according to time zone
        $today = $this->_timezoneInterface->date()->format('m/d/y H:i:s');

        // for convert date time according to magento time zone
        $dateTimeAsTimeZone = $this->_timezoneInterface
            ->date(new \DateTime($dateTime))
            ->format('m/d/y H:i:s');
        return $dateTimeAsTimeZone;
    }

}