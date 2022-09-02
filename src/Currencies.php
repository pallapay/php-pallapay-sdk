<?php

namespace Pallapay\PallapaySDK;

use Pallapay\PallapaySDK\Exceptions\InvalidCurrencyException;

class Currencies
{
    // FIAT CURRENCIES
    public const CURRENCY_AED = 'AED';
    public const CURRENCY_USD = 'USD';
    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_GBP = 'GBP';

    // CRYPTO CURRENCIES
    public const CURRENCY_BTC = 'BTC';
    public const CURRENCY_ETH = 'ETH';
    public const CURRENCY_TRX = 'TRON';
    public const CURRENCY_PALLA_TRC20 = 'PALLA';
    public const CURRENCY_USDT_TRC20 = 'USDT-TRC20';
    public const CURRENCY_USDT_ERC20 = 'USDT-ERC20';
    public const CURRENCY_USDC_ERC20 = 'USDC-ERC20';
    public const CURRENCY_DAI_ERC20 = 'DAI-ERC20';

    public const SUPPORTED_CURRENCIES = [
        self::CURRENCY_AED,
        self::CURRENCY_USD,
        self::CURRENCY_EUR,
        self::CURRENCY_GBP,
        self::CURRENCY_BTC,
        self::CURRENCY_ETH,
        self::CURRENCY_TRX,
        self::CURRENCY_PALLA_TRC20,
        self::CURRENCY_USDT_TRC20,
        self::CURRENCY_USDT_ERC20,
        self::CURRENCY_USDC_ERC20,
        self::CURRENCY_DAI_ERC20,
    ];

    /**
     * @param string $currency
     * @return bool
     */
    public static function isValidCurrency(string $currency): bool {
        return in_array($currency, self::SUPPORTED_CURRENCIES);
    }

    /**
     * @param string $currency
     * @return void
     * @throws InvalidCurrencyException
     */
    public static function validateCurrency(string $currency): void {
        if (!self::isValidCurrency($currency)) {
            throw new InvalidCurrencyException("Currency <$currency> is not supported.");
        }
    }
}
