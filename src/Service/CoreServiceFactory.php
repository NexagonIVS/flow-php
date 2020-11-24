<?php


namespace Flow\Service;

/**
 * Class CoreServiceFactory
 * @package Flow\Service
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    private static $class_map = [
        'products' => ProductService::class,
        'orders' => OrderService::class,
        'jobs' => JobService::class,
        'lines' => OrderLineService::class,
        'customerGroups' => CustomerGroupService::class,
        'dataSchemas' => DataSchemaService::class,
        'dataSchemaVersions' => DataSchemaVersionService::class,
        'files' => FileService::class
    ];

    protected function getServiceClass($name)
    {
        return array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}