<?php

namespace Flow\ApiOperations;

trait All
{
    abstract protected function getClassUrl(): string;
    abstract protected function get($path, $params = []);
    /**
     * Retreive all resources (paginated)
     * @param null|array $params
     * @throws \Flow\FlowException
     */
    public function all($params = [])
    {
        return $this->get($this->getClassUrl(), $params);
    }
}