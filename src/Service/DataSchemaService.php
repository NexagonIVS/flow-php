<?php


namespace Flow\Service;


class DataSchemaService extends AbstractService
{
    use \Flow\ApiOperations\All;
    use \Flow\ApiOperations\Retrieve;

    protected function getClassUrl(): string
    {
        return "data-schemas";
    }
}