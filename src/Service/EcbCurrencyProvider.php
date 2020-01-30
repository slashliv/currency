<?php

namespace App\Service;

use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class EcbCurrencyProvider extends AbstractCurrencyProvider
{
    /**
     * @inheritDoc
     */
    protected function processData(array $responseData): float
    {
        $currencies = $responseData['Cube']['Cube']['Cube'];
        foreach ($currencies as $currency) {
            if ('RUB' === $currency['@currency']) {
                return $currency['@rate'];
            }
        }

        throw new \LogicException('Currency not found');
    }

    /**
     * @inheritDoc
     */
    protected function getDecoder(): DecoderInterface
    {
        return new XmlEncoder();
    }
}
