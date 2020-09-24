<?php

namespace Flow\Service;

use Flow\FlowException;
use Flow\FlowClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
            return $path . http_build_query($params);
        } else {
            return $path;
        }
    }

    private function _decode_response($response)
    {
        if ($response->getStatusCode() > 299) {
            $fail_reason = $response->getStatusCode() < 500 ? $response->getBody()->getContents() : $response->getReasonPhrase();
            throw new FlowException($fail_reason, $response->getStatusCode());
        }
        return json_decode($response->getBody()->getContents());
    }

    protected function get($path, $params = [])
    {
        try {
            $response = $this->getClient()->get($this->_buildPath($path . '/', $params));
            return $this->_decode_response($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not get ' . $path, $e->getCode());
        }
    }

    protected function patch($path, $params, $body)
    {
        try {
            $response = $this->getClient()->patch($this->_buildPath($path . '/', $params), [
                "body" => json_encode($body)
            ]);
            return $this->_decode_response($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not update ' . $path, $e->getCode());
        }
    }

    protected function post($path, $params, $body)
    {
        try {
            $response = $this->getClient()->post($this->_buildPath($path . '/', $params), [
                "body" => json_encode($body)
            ]);
            return $this->_decode_response($response);
        } catch (GuzzleException $e) {
            throw new FlowException('Could not update ' . $path, $e->getCode());
        }
    }

}