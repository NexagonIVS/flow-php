<?php

namespace Flow\Service;

use Flow\FlowException;
use Flow\FlowClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractService
{
    /**
     * @var FlowClient
     */
    protected $flow_client;

    /**
     * AbstractService constructor.
     * @param FlowClient $flow_client
     */
    public function __construct(FlowClient $flow_client)
    {
        $this->flow_client = $flow_client;
    }

    /**
     * Get the client used by this service
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->flow_client->getClient();
    }

    private function _buildPath($path, $params = [])
    {
        if ($params and sizeof($params) > 0) {
            return $path . '?' . http_build_query($params);
        } else {
            return $path;
        }
    }

    private function _decodeResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() > 299) {
            $fail_reason = $response->getStatusCode() < 500 ? $response->getBody()->getContents() : $response->getReasonPhrase();
            throw new FlowException($fail_reason, $response->getStatusCode());
        }
        $body = json_decode($response->getBody()->getContents());
        return [$body, $response];
    }

    protected function get($path, $params = [])
    {
        try {
            $response = $this->getClient()->get($this->_buildPath($path . '/', $params));
            return $this->_decodeResponse($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not get ' . $path . ': ' . $e->getCode(), $e->getCode());
        }
    }

    protected function patch($path, $params, $body)
    {
        try {
            $response = $this->getClient()->patch($this->_buildPath($path . '/', $params), [
                "json" => $body
            ]);
            return $this->_decodeResponse($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not update ' . $path . ': ' . $e->getCode(), $e->getCode());
        }
    }

    protected function put($path, $params, $body)
    {
        try {
            $response = $this->getClient()->put($this->_buildPath($path . '/', $params), [
                "json" => $body
            ]);
            return $this->_decodeResponse($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not update ' . $path . ': ' . $e->getCode(), $e->getCode());
        }
    }

    protected function post($path, $params, $body)
    {
        try {
            $response = $this->getClient()->post($this->_buildPath($path . '/', $params), [
                "json" => $body
            ]);
            return $this->_decodeResponse($response);
        } catch (ClientException $e) {
            throw new FlowException(
                'Could not create ' . $path . ': ' .
                $e->getCode() . '. Error: ' .
                $e->getResponse()->getBody()->getContents(), $e->getCode());
        } catch (GuzzleException $e) {
            throw new FlowException('Could not create ' . $path . ': ' . $e->getCode(), $e->getCode());
        }
    }

    protected function del($path)
    {
        try {
            $response = $this->getClient()->delete($this->_buildPath($path . '/'));
            return $this->_decodeResponse($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not get ' . $path . ': ' . $e->getCode(), $e->getCode());
        }
    }

}