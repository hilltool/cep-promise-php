<?php

namespace Claudsonm\CepPromise\Contracts;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

abstract class BaseProvider implements ProviderInterface
{
    /**
     * O nome identificador do provedor de serviço.
     */
    const PROVIDER_IDENTIFIER = 'base_provider';

    /**
     * O cliente HTTP utilizado para realizar os requests.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * A instância da Promise para consulta no serviço de busca.
     *
     * @var \GuzzleHttp\Promise\Promise
     */
    protected $promise;

    /**
     * Construtor da classe.
     * @param  HandlerStack  $mocksHandler
     */
    protected function __construct(HandlerStack $mocksHandler = null)
    {
        $this->client = new Client([
            'handler' => $mocksHandler
        ]);
    }

    /**
     * Retorna um array associativo com o identificador do provider e a Promise.
     *
     * @param $cep
     *
     * @param  HandlerStack  $mockHandler
     * @return array
     */
    public static function createPromiseArray($cep, HandlerStack $mockHandler = null)
    {
        $class = get_called_class();
        $provider = new $class($mockHandler);
        $provider->makePromise($cep);

        return $provider->toArray();
    }

    /**
     * Retorna o provider em um array associativo onde a chave é o
     * identificador e o valor é a Promise.
     *
     * @return array
     */
    public function toArray()
    {
        return [get_called_class()::PROVIDER_IDENTIFIER => $this->promise];
    }
}
