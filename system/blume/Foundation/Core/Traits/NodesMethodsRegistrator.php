<?php

namespace Blume\Foundation\Core\Traits;

use \BadMethodCallException;
use \Closure;
use \InvalidArgumentException;

trait NodesMethodsRegistrator
{
    protected $methods = [];

    public function __call($method, array $arguments = [])
    {
        if (!$this->hasNodeMethod($method)) {
            throw new BadMethodCallException("Method '" . static::class . "::{$method}' is not exists");
        }

        return call_user_func_array($this->methods[$method], $arguments);
    }

    public function registerNodeMethod(string $method, $callback)
    {
        if (is_array($callback) and class_exists($callback[0])) {
            $callback[0] = new $callback[0];
        }

        if (!is_callable($callback) and !($callback instanceof Closure)) {
            throw new InvalidArgumentException("Callback for method '" . static::class . "::{$method}' must be callable or instantiable of Closure");
        }

        $this->methods[$method] = $callback;
    }

    public function hasNodeMethod(string $method)
    {
        return isset($this->methods[$method]);
    }
}
