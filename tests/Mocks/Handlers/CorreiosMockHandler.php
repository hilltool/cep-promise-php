<?php

namespace Claudsonm\CepPromise\Tests\Mocks\Handlers;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class CorreiosMockHandler implements ProviderMockHandlerContract
{
    /**
     * Pilha com o mock dos requests de sucesso para consulta ao CEP 05010000.
     *
     * @return HandlerStack
     */
    public static function successMockedResponse()
    {
        $handler = new MockHandler([
            new Response(200, [], fopen('tests/Mocks/Assets/correios-cep-05010000-found.xml', 'r')),
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
            new Response(500, [], fopen('tests/Mocks/Assets/correios-cep-99999999-error.xml', 'r')),
        ]);
        $mockStack = HandlerStack::create($handler);

        return $mockStack;
    }

    /**
     * Pilha com o mock dos requests com um XML de resposta fora do esperado.
     *
     * @return HandlerStack
     */
    public static function badXmlMockedResponse()
    {
        $handler = new MockHandler([
            new Response(200, [], fopen('tests/Mocks/Assets/correios-bad-xml.xml', 'r')),
        ]);
        $mockStack = HandlerStack::create($handler);

        return $mockStack;
    }

    /**
     * Pilha com o mock dos requests com uma exceção na tentativa de conexão.
     *
     * @return HandlerStack
     */
    public static function errorCommunicatingWithServer()
    {
        $handler = new MockHandler([
            new RequestException('Erro ao se comunicar com o servidor', new Request('POST', 'testing'))
        ]);
        $mockStack = HandlerStack::create($handler);

        return $mockStack;
    }
}
