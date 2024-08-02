<?php

namespace Blume\Foundation\Core\Traits;

use \BadMethodCallException;

trait NodesRegistrator
{
    protected $nodes = [];

    public function __call(string $node, array $arguments = [])
    {
        if (!$this->hasNode($node)) {
            throw new BadMethodCallException("Method '{$node}' is not exists");
        }

        return app($this->nodes[$node]);
    }

    public function registerNode(string $node, string $service): self
    {
        $this->nodes[$node] = $service;

        $this->registerService($service);

        return $this;
    }

    public function registerNodeMethod(string $node, string $method, $callback): self
    {
        if (!$this->hasNode($node)) {
            throw new BadMethodCallException("Definition '{$node}' not exists");
        }

        app($this->nodes[$node])->registerNodeMethod($method, $callback);

        return $this;
    }

    public function hasNode(string $node): bool
    {
        return isset($this->nodes[$node]) && app()->bound($this->nodes[$node]);
    }

    protected function registerService(string $service): void
    {
        if (!app()->bound($service)) {
            app()->singleton($service, function ($app) use ($service) {
                return new $service();
            });
        }
    }
}
