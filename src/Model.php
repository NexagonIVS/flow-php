<?php

namespace Nexagon;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\RejectionException;
use Flow\FlowException;

final class Model
{
    protected $model_name;
    protected $client;

    public function __construct(string $model_name, Client $client)
    {
        $this->model_name = $model_name;
        $this->client = $client;
    }

    public function retrieve($id)
    {
        try {
            $response = $this->client->get('/' . $this->model_name);
            if ($response->getStatusCode() !== 200) {
                throw new FlowException($response->getReasonPhrase(), $response->getStatusCode());
            }
            return json_decode($response->getBody()->getContents());
        } catch (RejectionException $e) {
            throw new FlowException('Could not get ' . $this->model_name, $e->getCode());
        }
    }

    /**
     * @param array $options
     */
    public function all($options = [
        "limit" => 10,
        "offset" => 0,
        "search" => null,
        "filter" => [],
    ])
    {

    }

}