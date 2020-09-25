<?php


namespace Flow\Service;


class DataSchemaVersionService extends AbstractService
{
    use \Flow\ApiOperations\Retrieve;

    protected function getClassUrl(): string
    {
        return "data-schema-versions";
    }
}