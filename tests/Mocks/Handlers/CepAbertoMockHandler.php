<?php

namespace Claudsonm\CepPromise\Tests\Mocks\Handlers;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class CepAbertoMockHandler implements ProviderMockHandlerContract
{
    /**
     * Pilha com o mock dos requests de sucesso para consulta ao CEP 05010000.
     *
     * @return HandlerStack
     */
    public static function successMockedResponse()
    {
        $handler = new MockHandler([
            new Response(200, [], fopen('tests/Mocks/Assets/cep_aberto-cep-05010000-found.json', 'r')),
        ]);
        $mockStack = HandlerStack::create($handler);

        return $mockStack;
    }

    /**
     * Pilha com o mock dos requests de erro para consulta ao CEP 99999999.
     *
     * @return HandlerStack
     */
    public static function errorMockedResponse()
    {
        $handler = new MockHandler([
            new Response(200, [], fopen('tests/Mocks/Assets/cep_aberto-cep-99999999-error.json', 'r')),
        ]);
        $mockStack = HandlerStack::create($handler);

        return $mockStack;
    }
}
