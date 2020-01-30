<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class CbrCurrencyProvider extends AbstractCurrencyProvider
{
    /**
     * @inheritDoc
     */
    public function processData(array $responseData): float
    {
        return $responseData['Valute']['EUR']['Value'];
    }

    /**
     * @inheritDoc
     */
    protected function getDecoder(): DecoderInterface
    {
        return new JsonEncoder();
    }
}
