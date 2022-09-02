## Pallapay crypto payment gateway SDK

Easy to use SDK for pallapay crypto payment gateway, accept crypto in your website and get paid in cash.


#### Installation
```
composer require pallapay/php-pallapay-sdk
```

#### Easy to use

First signup and [get you merchant ID from pallapay website](https://www.pallapay.com/account/merchants/add)

Then you can create a payment link:

```php
use Pallapay\PallapaySDK\Pallapay;
$pallapay = new Pallapay();

$ipnData = $pallapay->payment()->createPayment('YOUR_MERCHANT_ID', 'YOUR_ORDER_ID', 100, 'AED', 'PAYER_FIRST_NAME', 'PAYER_LAST_NAME', 'PAYER_EMAIL_ADDRESS', 'YOUR_CUSTOM_DATA');
```

`createPayment` params:

| Name            | Description                                                                                                        | Required |
|-----------------|--------------------------------------------------------------------------------------------------------------------|----------|
| $merchantId     | Your merchant ID (You can create one in pallapay panel)                                                            | YES      |
| $orderId        | Order ID for your payment                                                                                          | YES      |
| $amount         | Amount in selected currency                                                                                        | YES      |
| $currency       | Currency of the payment (You can find all available currencies down bellow)                                        | YES      |
| $payerFirstName | Payer first name                                                                                                   | YES      |
| $payerLastName  | Payer last name                                                                                                    | YES      |
| $payerEmail     | Payer email                                                                                                        | YES      |
| $customData     | You can pass your custom data here. for example, your customers order ID. This item is not displayed to the buyer. | NO       |


After that you can redirect user to `redirect_to_url`.

#### Handle IPN

After user payment was done, we will call your IPN_NOTIFY_URL that you entered when you created your merchant.

In that page you can use this `getIpnRequest` method to get payment details and then verify it.

```php
use Pallapay\PallapaySDK\Pallapay;

$pallapay = new Pallapay();
$ipnData = $pallapay->payment()->getIpnRequest();

if ($ipnData->isValid('MERCHANT_PASSWORD') && $ipnData->isPaid()) {
    print_r($ipnData->getAll())
    echo 'CONFIRMED PAYMENT';
} else {
    echo 'NOT PAID';
}
```

`IpnData` Available methods:

| method          | Description                                                                                                              |
|-----------------|--------------------------------------------------------------------------------------------------------------------------|
| isValid         | Check if IPN request was valid (Was really sent from pallapay)                                                           |
| isPaid          | Check if user payment status was PAID                                                                                    |
| getAll          | Get everything from IPN request in an array                                                                              |
| getAmount       | Get the received amount without commissions                                                                              |
| getFee          | Get fee that was paid (Note: Paid by the buyer or merchant according to the merchant settings in pallapay dashboard)     |
| getTotal        | Get total transaction amount including commission                                                                        |
| getCurrency     | Transaction currency                                                                                                     |
| getPayer        | Get payer name                                                                                                           |
| getReceiver     | Get merchant username in Pallapay                                                                                        |
| getStatus       | Get transaction status                                                                                                   |
| getDate         | Get transaction date                                                                                                     |
| getTransferId   | Get unique transaction number in Pallapay                                                                                |
| getMerchantName | Get merchant name                                                                                                        |
| getMerchantId   | Get merchant ID                                                                                                          |
| getBalance      | Get available merchant balance in transaction currency                                                                   |
| getItemName     | Get item name                                                                                                            |
| getCustom       | Get custom data that you sent for create payment                                                                         |
| getHash         | Get encrypted hash to check validity of IPN request (Note: You can check by yourself or you can check by isValid method) |

#### Supported currencies

| Supported Currencies |
|----------------------|
| AED                  |
| USD                  |
| EUR                  |
| GBP                  |
| BTC                  |
| ETH                  |
| TRON                 |
| PALLA                |
| USDT-TRC20           |
| USDT-ERC20           |
| USDC-ERC20           |
| DAI-ERC20            |

And you can find supported currencies constants here:

```php
use Pallapay\PallapaySDK\Currencies;

Currencies::CURRENCY_AED;
Currencies::CURRENCY_USD;
Currencies::CURRENCY_EUR;
Currencies::CURRENCY_GBP;
Currencies::CURRENCY_BTC;
Currencies::CURRENCY_ETH;
Currencies::CURRENCY_TRX;
Currencies::CURRENCY_PALLA_TRC20;
Currencies::CURRENCY_USDT_TRC20;
Currencies::CURRENCY_USDT_ERC20;
Currencies::CURRENCY_USDC_ERC20;
Currencies::CURRENCY_DAI_ERC20;
```

#### Contribution

Contributions are highly appreciated either in the form of pull requests for new features, bug fixes or just bug reports.

----------------------------------------------

[Pallapay Website](https://www.pallapay.com)

