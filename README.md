
## SMSGlobal SMS Integration Magento 2 Module

The SMSGlobal SMS Integration is an integration with the Magento e-commerce platform. This Integration enables Magento store admins to configure automated SMS notifications to the administrator and customers for important order status updates, and also allows sending bulk SMS messages to customers. The Integration is free, but a SMSGlobal MXT account is required to send messages. Signup with our service is free as well, and you pay only for the SMS messages. The Integration offers great flexibility, in sending individual SMS or bulk SMS messages to various groups.


## SMSGlobal Benefits

* Competitive Mass and Bulk SMS Pricing
* Wholesale pricing 
* 99.9% On-net network redundancy
* 99.9% up-time availability
* Enterprise Scalability
* API Flexibility
* No setup fees - No contracts - No catches

## Integration Compatibility

* Magento Community Edition: 2.2 and 2.4


## Features


* Easy options to check the balance, login to MXT, get support and buy credits.<br/>
* Allows flexibility in enabling/disabling the Integration as well as setting individual triggers.<br/>
* When a new order is placed<br/>
* When the order is paid (invoice created)<br/>
* When a new shipment is created<br/>
* when order is canceled<br/>
* when order is refunded (Credit Memo)<br/>
* when order is on hold<br/>
* when order is on unhold<br/>
* Allows you to send/schedule individual SMS messages<br/>
* Allows you to send bulk SMS to customers.<br/>
* Allows you to send individual SMS to customer<br/>
* Options to send notifications to admin for all the triggers.<br/>
* Instantly check whether the settings are correct by sending a test message.<br/>
* Provide a complete list of sent messages history with the details and the status of the message.
* Supports Unicode SMS messages.
</p>
<br/>

## Install

* Go to Magento2 root folder

* Enter following command to install module:

```bash
composer require smsglobal/module-sms
```


* Enter following commands to enable module:

```bash
php bin/magento module:enable Smsglobal_Sms --clear-static-content
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

## Support

For general support or questions about your SMSGlobal account, you can reach out to  [our website](https://smsglobal.com/support/).
