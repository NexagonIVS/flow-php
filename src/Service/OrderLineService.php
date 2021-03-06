<?php


namespace Flow\Service;


class OrderLineService extends AbstractService
{
    use \Flow\ApiOperations\All;
    use \Flow\ApiOperations\Retrieve;
    use \Flow\ApiOperations\Create;
    use \Flow\ApiOperations\Update;
    use \Flow\ApiOperations\Delete;

    protected function getClassUrl(): string
    {
        return "order-lines";
    }
}