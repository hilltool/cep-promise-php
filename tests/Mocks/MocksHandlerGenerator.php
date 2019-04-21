<?php

namespace Claudsonm\CepPromise\Tests\Mocks;

use Claudsonm\CepPromise\Providers\CepAbertoProvider;
use Claudsonm\CepPromise\Providers\CorreiosProvider;
use Claudsonm\CepPromise\Providers\ViaCepProvider;
use Claudsonm\CepPromise\Tests\Mocks\Handlers\CepAbertoMockHandler;
use Claudsonm\CepPromise\Tests\Mocks\Handlers\CorreiosMockHandler;
use Claudsonm\CepPromise\Tests\Mocks\Handlers\ViaCepMockHandler;

class MocksHandlerGenerator
{
    public static function makeSuccessMocksForCep05010000()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::successMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::successMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::successMockedResponse(),
        ];
    }

    public static function makeSuccessMockOnlyForCorreiosProvider()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::errorMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::errorMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::successMockedResponse(),
        ];
    }

    public static function makeSuccessMockOnlyForViaCepProvider()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::successMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::errorMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::errorMockedResponse(),
        ];
    }

    public static function makeSuccessMockOnlyForCepAbertoProvider()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::errorMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::successMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::errorMockedResponse(),
        ];
    }

    public static function makeSuccessMockWithBadCorreiosProviderXml()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::successMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::successMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::badXmlMockedResponse(),
        ];
    }

    public static function makeSuccessMockWithBadResponseFromCorreiosProvider()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::successMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::successMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::errorCommunicatingWithServer(),
        ];
    }

    public static function makeErrorResponseForNonExistentCep()
    {
        return [
            ViaCepProvider::PROVIDER_IDENTIFIER => ViaCepMockHandler::errorMockedResponse(),
            CepAbertoProvider::PROVIDER_IDENTIFIER => CepAbertoMockHandler::errorMockedResponse(),
            CorreiosProvider::PROVIDER_IDENTIFIER => CorreiosMockHandler::errorMockedResponse(),
        ];
    }
}
