<?php

namespace Pallapay\PallapaySDK;


class IpnData
{
    private const CONFIRMED_STATUS = 'CONFIRMED';

    /**
     * @var string $amount
     */
    private string $amount;

    /**
     * @var string $fee
     */
    private string $fee;

    /**
     * @var string $total
     */
    private string $total;

    /**
     * @var string $currency
     */
    private string $currency;

    /**
     * @var string $payer
     */
    private string $payer;

    /**
     * @var string $receiver
     */
    private string $receiver;

    /**
     * @var string $status
     */
    private string $status;

    /**
     * @var string $date
     */
    private string $date;

    /**
     * @var string $transferId
     */
    private string $transferId;

    /**
     * @var string $merchantName
     */
    private string $merchantName;

    /**
     * @var string $merchantId
     */
    private string $merchantId;

    /**
     * @var string $balance
     */
    private string $balance;

    /**
     * @var string $itemName
     */
    private string $itemName;

    /**
     * @var string $orderId
     */
    private string $orderId;

    /**
     * @var mixed|null $custom
     */
    private $custom;

    /**
     * @var string $hash
     */
    private string $hash;

    /**
     * @param string $amount
     * @param string $fee
     * @param string $total
     * @param string $currency
     * @param string $payer
     * @param string $receiver
     * @param string $status
     * @param string $date
     * @param string $transferId
     * @param string $merchantName
     * @param string $merchantId
     * @param string $balance
     * @param string $itemName
     * @param string $hash
     * @param string $orderId
     * @param $custom
     */
    function __construct(string $amount, string $fee, string $total, string $currency, string $payer, string $receiver, string $status, string $date, string $transferId, string $merchantName, string $merchantId, string $balance, string $itemName, string $hash, string $orderId, $custom = null) {
        $this->amount = $amount;
        $this->fee = $fee;
        $this->total = $total;
        $this->currency = $currency;
        $this->payer = $payer;
        $this->receiver = $receiver;
        $this->status = $status;
        $this->date = $date;
        $this->transferId = $transferId;
        $this->merchantName = $merchantName;
        $this->merchantId = $merchantId;
        $this->balance = $balance;
        $this->itemName = $itemName;
        $this->hash = $hash;
        $this->orderId = $orderId;
        $this->custom = $custom;
    }

    /**
     * @param string $merchantPassword
     * @return bool
     */
    public function isValid(string $merchantPassword): bool {
        $requestHash = strtoupper(md5($this->getTotal() . ':' . $merchantPassword . ':' . $this->getDate() . ':' . $this->getTransferId()));
        return $this->getHash() == $requestHash;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool {
        return $this->getStatus() == self::CONFIRMED_STATUS;
    }

    /**
     * @return array
     */
    public function getAll(): array {
        return [
            'amount'       => $this->getAmount(),
            'fee'          => $this->getFee(),
            'total'        => $this->getTotal(),
            'currency'     => $this->getCurrency(),
            'payer'        => $this->getPayer(),
            'receiver'     => $this->getReceiver(),
            'status'       => $this->getStatus(),
            'date'         => $this->getDate(),
            'transferId'   => $this->getTransferId(),
            'merchantName' => $this->getMerchantName(),
            'merchantId'   => $this->getMerchantId(),
            'balance'      => $this->getBalance(),
            'itemName'     => $this->getItemName(),
            'hash'         => $this->getHash(),
            'orderId'      => $this->getOrderId(),
            'custom'       => $this->getCustom()
        ];
    }

    /**
     * @return string
     */
    public function getAmount(): string {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getFee(): string {
        return $this->fee;
    }

    /**
     * @return string
     */
    public function getTotal(): string {
        return $this->total;
    }

    /**
     * @return string
     */
    public function getCurrency(): string {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getPayer(): string {
        return $this->payer;
    }

    /**
     * @return string
     */
    public function getReceiver(): string {
        return $this->receiver;
    }

    /**
     * @return string
     */
    public function getStatus(): string {
        return strtoupper($this->status);
    }

    /**
     * @return string
     */
    public function getDate(): string {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getTransferId(): string {
        return $this->transferId;
    }

    /**
     * @return string
     */
    public function getMerchantName(): string {
        return $this->merchantName;
    }

    /**
     * @return string
     */
    public function getMerchantId(): string {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getBalance(): string {
        return $this->balance;
    }

    /**
     * @return string
     */
    public function getItemName(): string {
        return $this->itemName;
    }

    /**
     * @return mixed|null
     */
    public function getCustom() {
        return $this->custom;
    }

    /**
     * @return string
     */
    public function getHash(): string {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getOrderId(): string {
        return $this->orderId;
    }
}
