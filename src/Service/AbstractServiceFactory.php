<?php


namespace Flow\Service;


use Flow\FlowClient;

abstract class AbstractServiceFactory
{
    private $flow_client;

    /**
     * @var array<string, AbstractService|AbstractServiceFactory>
     */
    private $services;

    /**
     * AbstractServiceFactory constructor.
     * @param FlowClient $flow_client
     */
    public function __construct(FlowClient $flow_client)
    {
        $this->flow_client = $flow_client;
        $this->services = [];
    }

    abstract protected function getServiceClass($name);

    /**
     * @param string $name
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function __get($name)
    {
        $service_class = $this->getServiceClass($name);
        if (null !== $service_class) {
            if (!array_key_exists($name, $this->services)) {
                $this->services[$name] = new $service_class($this->flow_client);
            }
            return $this->services[$name];
        }
        trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }
}