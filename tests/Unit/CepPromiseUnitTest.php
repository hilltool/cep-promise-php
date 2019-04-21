<?php

namespace Claudsonm\CepPromise\Tests\Unit;

use Claudsonm\CepPromise\CepPromise;
use Claudsonm\CepPromise\Exceptions\CepPromiseException;
use Claudsonm\CepPromise\Tests\Mocks\MocksHandlerGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class CepPromiseUnitTest extends TestCase
{
    public function testErrorTryingToFetchPassingAFunction()
    {
        $this->expectException(CepPromiseException::class);
        $this->expectExceptionMessage('Erro ao inicializar a instância do CepPromise.');
        $this->expectExceptionCode(1);
        CepPromise::fetch(function () {
            return 'You shall not pass!';
        });
    }

    public function testErrorTryingToFetchPassingAnArray()
    {
        $this->expectException(CepPromiseException::class);
        $this->expectExceptionMessage('Erro ao inicializar a instância do CepPromise.');
        $this->expectExceptionCode(1);
        CepPromise::fetch([53020665]);
    }

    public function testErrorTryingToFetchPassingAnObject()
    {
        $this->expectException(CepPromiseException::class);
        $this->expectExceptionMessage('Erro ao inicializar a instância do CepPromise.');
        $this->expectExceptionCode(1);
        CepPromise::fetch((object) ['top_gear' => '1000', 'gta' => '900']);
    }

    public function testErrorTryingToFetchWithoutArgument()
    {
        $this->expectException(\ArgumentCountError::class);
        CepPromise::fetch();
    }

    public function testIfFetchMethodExists()
    {
        $this->assertTrue(method_exists(CepPromise::class, 'fetch'));
    }

    public function testIfFetchMethodIsStatic()
    {
        $fetchMethod = new ReflectionMethod(CepPromise::class, 'fetch');
        $this->assertTrue($fetchMethod->isStatic());
    }

    public function testFetchingUsingValidString()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMocksForCep05010000();
        $address = CepPromise::fetch('05010000', $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testFetchingUsingValidNumber()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMocksForCep05010000();
        $address = CepPromise::fetch(5010000, $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testShouldSucceedOnlyWithCorreiosProvider()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMockOnlyForCorreiosProvider();
        $address = CepPromise::fetch('5010000', $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testShouldSucceedOnlyWithViaCepProvider()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMockOnlyForViaCepProvider();
        $address = CepPromise::fetch('5010000', $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testShouldSucceedOnlyWithCepAbertoProvider()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMockOnlyForCepAbertoProvider();
        $address = CepPromise::fetch('5010000', $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testSucceedWithOneFailOverServicesWhenNotPossibleToParseCorreiosXmlResponse()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMockWithBadCorreiosProviderXml();
        $address = CepPromise::fetch('5010000', $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testSucceedWithOneFailOverServicesWhenHttpRequestToCorreiosFail()
    {
        $handlers = MocksHandlerGenerator::makeSuccessMockWithBadResponseFromCorreiosProvider();
        $address = CepPromise::fetch('5010000', $handlers);
        $this->assertEquals('05010000', $address->zipCode);
        $this->assertEquals('SP', $address->state);
        $this->assertEquals('São Paulo', $address->city);
        $this->assertEquals('Perdizes', $address->district);
        $this->assertEquals('Rua Caiubi', $address->street);
    }

    public function testErrorTryingToFetchNonExistentCep()
    {
        $handlers = MocksHandlerGenerator::makeErrorResponseForNonExistentCep();
        $this->expectException(CepPromiseException::class);
        $this->expectExceptionMessage('Todos os serviços de CEP retornaram erro.');
        $this->expectExceptionCode(2);
        CepPromise::fetch('99999999', $handlers);
    }
}
