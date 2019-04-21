<?php

namespace Claudsonm\CepPromise\Tests\Mocks\Handlers;

interface ProviderMockHandlerContract
{
    /**
     * Pilha com o mock dos requests de sucesso para consulta ao CEP 05010000.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    public static function successMockedResponse();

    /**
     * Pilha com o mock dos requests de erro para consulta ao CEP 99999999.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    public static function errorMockedResponse();
}
