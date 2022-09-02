<?php

namespace Pallapay\PallapaySDK\Api;

use GuzzleHttp\Exception\GuzzleException;
use Pallapay\PallapaySDK\Exceptions\ApiException;
use Pallapay\PallapaySDK\Exceptions\InvalidCurrencyException;
use Pallapay\PallapaySDK\Exceptions\IpnException;
use Pallapay\PallapaySDK\IpnData;
use Pallapay\PallapaySDK\Request;
use Pallapay\PallapaySDK\Currencies;

class Payment extends Request
{
    public function __construct(string $host)
    {
        $this->setHost($host);
    }

    /**
     * @param string $merchantId
     * @param string $orderId
     * @param float $amount
     * @param string $currency
     * @param string $payerFirstName
     * @param string $payerLastName
     * @param string $payerEmail
     * @param string|null $customData
     * @return mixed
     * @throws ApiException
     * @throws InvalidCurrencyException
     * @throws GuzzleException
     */
    public function createPayment(string $merchantId, string $orderId, float $amount, string $currency,
                                  string $payerFirstName, string $payerLastName, string $payerEmail,
                                  string $customData = null) {

        Currencies::validateCurrency($currency);

        $this->addJsonParam('order', $orderId);
        $this->addJsonParam('merchant', $merchantId);
        $this->addJsonParam('amount', $amount);
        $this->addJsonParam('currency', $currency);
        $this->addJsonParam('custom', $customData);
        $this->addJsonParam('first_name', $payerFirstName);
        $this->addJsonParam('last_name', $payerLastName);
        $this->addJsonParam('email', $payerEmail);

        return $this->sendRequest(self::POST_METHOD, '/api/v1/request/createOrder');
    }

    /**
     * @param array|null $postData
     * @return IpnData
     * @throws IpnException
     */
    public function getIpnRequest(array $postData = null): IpnData {
        if ($postData === null || $postData == []) {
            $postData = $_POST;
        }

        $this->validateIpnRequest($postData);

        return new IpnData(
            $postData['amount'],
            $postData['fee'],
            $postData['total'],
            $postData['currency'],
            $postData['payer'],
            $postData['receiver'],
            $postData['status'],
            $postData['date'],
            $postData['id_transfer'],
            $postData['merchant_name'],
            $postData['merchant_id'],
            $postData['balance'],
            $postData['item_name'],
            $postData['hash'],
            $postData['custom'] ?? null
        );
    }

    /**
     * @param array|null $postData
     * @return void
     * @throws IpnException
     */
    private function validateIpnRequest(array $postData = null): void {
        $requiredInputs = ['amount', 'fee', 'total', 'currency', 'payer', 'receiver', 'status', 'date', 'id_transfer',
            'merchant_name', 'merchant_id', 'balance', 'item_name', 'hash'];

        foreach ($requiredInputs as $requiredInput) {
            if (!isset($postData[$requiredInput]) || !is_string($postData[$requiredInput])) {
                throw new IpnException("Input error in IPN request ($requiredInput), Input does not exist or it is not string.");
            }
        }
    }
}
