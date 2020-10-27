<?php


namespace Flow\Service;


class OrderService extends AbstractService
{
    use \Flow\ApiOperations\All;
    use \Flow\ApiOperations\Retrieve;
    use \Flow\ApiOperations\Create;
    use \Flow\ApiOperations\Update;
    use \Flow\ApiOperations\Delete;

    protected function getClassUrl(): string
    {
        return "orders";
    }

    /**
     * @param string|integer $id    the id of the order
     * @return array                [$data, $response]
     */
    public function startProduction($id)
    {
        return $this->put($this->getClassUrl() . '/' . $id . '/start_production', [], null);
    }
}