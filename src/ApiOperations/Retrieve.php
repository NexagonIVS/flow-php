<?php

namespace Flow\ApiOperations;

trait Retrieve
{
    abstract protected function getClassUrl(): string;
    abstract protected function get($path, $params = []);

    /**
     * Retreive a single resource by id
     * @param string|int $id
     */
    public function retrieve($id)
    {
        return $this->get($this->getClassUrl() . '/' . $id);
    }
}