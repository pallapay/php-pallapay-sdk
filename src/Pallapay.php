<?php

namespace Pallapay\PallapaySDK;

use Pallapay\PallapaySDK\Api\Payment;

class Pallapay
{
    protected string $host;

    function __construct(string $host = 'https://www.pallapay.com'){
        $this->host = $host;
    }

    /**
     * @return Payment
     */
    public function payment(): Payment
    {
        return new Payment($this->host);
    }
}
