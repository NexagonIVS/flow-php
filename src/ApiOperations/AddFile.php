<?php

namespace Flow\ApiOperations;

trait AddRemoveFile
{
    abstract protected function getClassUrl(): string;
    abstract protected function put($path, $params, $body);

    /**
     * @param string|int $id                    the id of the resource to update
     * @param string|int $file_id               the id of the file add
     * @return array                            a touple of [response data, response]
     * @throws \Flow\FlowException
     */
    public function addFile($id, $file_id)
    {
        return $this->put($this->getClassUrl() . '/' . $id . '/add_file', [], [
            "file" => $file_id
        ]);
    }

    /**
     * @param string|int $id                    the id of the resource to update
     * @param string|int $file_id               the id of the file remove
     * @return array                            a touple of [response data, response]
     * @throws \Flow\FlowException
     */
    public function removeFile($id, $file_id)
    {
        return $this->put($this->getClassUrl() . '/' . $id . '/remove_file/' . $file_id, [], [
            "file" => $file_id
        ]);
    }
}
