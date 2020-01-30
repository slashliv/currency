<?php

namespace App\Service;

use App\Exception\CurrencyFetchException;

class ChainCurrencyProvider implements CurrencyProviderInterface
{
    /**
     * @var CurrencyProviderInterface[]
     */
    private $providers;

    /**
     * @var string[]
     */
    private $ordering;

    public function __construct(array $ordering)
    {
        $this->providers = [];
        $this->ordering = $ordering;
    }

    /**
     * @param string $name
     * @param CurrencyProviderInterface $provider
     */
    public function addProvider(string $name, CurrencyProviderInterface $provider)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @return float
     */
    public function getCurrency(): float
    {
        foreach ($this->ordering as $providerCode) {
            $provider = $this->providers[$providerCode];

            try {
                return $provider->getCurrency();
            } catch (CurrencyFetchException $exception) {
                continue;
            }
        }

        throw new CurrencyFetchException('Currency can not be found');
    }
}
