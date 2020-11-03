<?php

namespace Flow;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;

/**
 * Class FlowClient
 * @package Flow

 * @property Service\ProductService $products
 * @property Service\OrderService $orders
 * @property Service\OrderLineService $lines
 * @property Service\DataSchemaService $dataSchemas
 * @property Service\DataSchemaVersionService $dataSchemaVersions
 * @property Service\CustomerGroupService $customerGroups
 * @property Service\FileService $files
 * @property Service\HookService $hooks
 */
final class FlowClient
{

    const API_VERSION = "v1";

    private $client;
    private $client_handler;

    private $coreServiceFactory;

    private $api_endpoint;
    private $api_key;

    /**
     * FlowClient constructor.
     * @param string $api_key       api key to use for authentication
     * @param string $api_endpoint  api endpoint, defaults https://api.nexagon.dk
     * @param null $handler         Used for test purposes
     */
    public function __construct(string $api_key, string $api_endpoint = 'https://api.nexagon.dk/', $handler = null)
    {
        $this->api_key = $api_key;
        $this->api_endpoint = $api_endpoint;
        $this->client_handler = $handler;
        $this->_buildHttpClient();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    private function _buildHttpClient(): Client
    {
        $handlerStack = null;
        if (null !== $this->client_handler) {
            $handlerStack = new HandlerStack($this->client_handler);
        }
        $this->client = new Client([
            'base_uri' => $this->api_endpoint,
            'headers' => [
                'X-API-KEY' => $this->api_key,
            ],
            'handler' => $handlerStack
        ]);
        return $this->client;
    }

    public function setApiKey(string $api_key)
    {
        $this->api_key = $api_key;
        $this->_buildHttpClient();
    }

    public function setApiEndpoint(string $api_ednpoint)
    {
        $this->api_endpoint = $api_ednpoint;
        $this->_buildHttpClient();
    }

    public function headApi($path)
    {
        try {
            $response = $this->_buildHttpClient()->head($path);
            return $response->getHeaders();
        } catch (GuzzleException $e) {
            throw new FlowException($e->getMessage(), $e->getCode());
        }
    }

    public function __get($name)
    {
        if (null === $this->coreServiceFactory) {
            $this->coreServiceFactory = new Service\CoreServiceFactory($this);
        }
        return $this->coreServiceFactory->__get($name);
    }
}