<?php

namespace Flow\ApiOperations;

trait Delete
{
    abstract protected function getClassUrl(): string;
    abstract protected function del($path);

    /**
     * Retreive a single resource by id
     * @param string|int $id
     */
    public function delete($id)
    {
        return $this->del($this->getClassUrl() . '/' . $id);
    }
}