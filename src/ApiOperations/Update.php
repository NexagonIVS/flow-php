<?php

namespace Flow\ApiOperations;

trait Update
{
    abstract protected function getClassUrl(): string;
    abstract protected function patch($path, $params, $body);

    /**
     * @param string|int $id                    the id of the resource to update
     * @param object|array<string, mixed> $data the data to update
     * @return array                            a touple of [response data, response]
     * @throws \Flow\FlowException
     */
    public function update($id, $data = [])
    {
        return $this->patch($this->getClassUrl() . '/' . $id, [], $data);
    }
}
