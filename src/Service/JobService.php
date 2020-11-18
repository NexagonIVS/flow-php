<?php


namespace Flow\Service;


class JobService extends AbstractService
{
    use \Flow\ApiOperations\All;
    use \Flow\ApiOperations\Retrieve;
    use \Flow\ApiOperations\Create;
    use \Flow\ApiOperations\Update;
    use \Flow\ApiOperations\Delete;

    protected function getClassUrl(): string
    {
        return "jobs";
    }

    /**
     * @param string|integer $id    the id of the job
     * @return array                [$data, $response]
     */
    public function cancelProduction($id)
    {
        return $this->put($this->getClassUrl() . '/' . $id . '/cancel_production', [], null);
    }
}
