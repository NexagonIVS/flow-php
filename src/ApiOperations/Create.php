<?php

namespace Flow\ApiOperations;

trait Create
{
    abstract protected function getClassUrl(): string;
    abstract protected function post($path, $params, $body);

    /**
     * @param object|array<string, mixed> $data the data to create a resource from
     * @return mixed                            a newly created resource
     * @throws \Flow\FlowException
     */
    public function create($data)
    {
        return $this->post($this->getClassUrl(), [], $data);
    }
}