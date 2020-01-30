<?php

namespace App\Service;

interface CurrencyProviderInterface
{
    /**
     * @return float
     */
    public function getCurrency(): float;
}
