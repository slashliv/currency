<?php

namespace App\Controller;

use App\Exception\CurrencyFetchException;
use App\Service\CurrencyProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends AbstractController
{
    /**
     * @var CurrencyProviderInterface
     */
    private $currencyProvider;

    /**
     * @param CurrencyProviderInterface $currencyProvider
     */
    public function __construct(CurrencyProviderInterface $currencyProvider)
    {
        $this->currencyProvider = $currencyProvider;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->render('app.html.twig');
        }

        try {
            $currency = $this->currencyProvider->getCurrency();
        } catch (CurrencyFetchException $exception) {
            return new JsonResponse([
                'success' => false,
                'error' => $exception->getMessage(),
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'currency' => $currency,
        ]);
    }
}
