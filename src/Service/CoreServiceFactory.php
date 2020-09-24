<?php


namespace Flow\Service;

/**
 * Class CoreServiceFactory
 * @package Flow\Service
 *
 * @property ProductService $products
 * @property OrderService $OrderService
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    private static $class_map = [
        'products' => ProductService::class,
        'orders' => OrderService::class,
    ];

    protected function getServiceClass($name)
    {
        return array_key_exists($name, self::$class_map) ? self::$class_map[$name] : null;
    }
}