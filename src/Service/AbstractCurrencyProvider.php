<?php

namespace App\Service;

use App\Exception\CurrencyFetchException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

abstract class AbstractCurrencyProvider implements CurrencyProviderInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @param array $responseData
     *
     * @return float
     */
    abstract protected function processData(array $responseData): float;

    /**
     * @return DecoderInterface
     */
    abstract protected function getDecoder(): DecoderInterface;

    /**
     * @return float
     */
    public function getCurrency(): float
    {
        $client = $this->getClient();

        try {
            $response = $client->request('GET', $this->url);
        } catch (ConnectException|BadResponseException $exception) {
            throw new CurrencyFetchException();
        }
        $response = $response->getBody()->getContents();
        $responseData = $this->decodeResponse($response);

        return $this->processData($responseData);
    }

    /**
     * @param string $responseBody
     *
     * @return array
     */
    protected function decodeResponse(string $responseBody)
    {
        $decoder = $this->getDecoder();

        return $this->getDecoder()->decode($responseBody, $decoder::FORMAT);
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return new Client([
            'timeout' => 1,
        ]);
    }
}