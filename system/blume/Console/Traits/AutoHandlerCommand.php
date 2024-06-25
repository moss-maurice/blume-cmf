<?php

namespace Blume\Console\Traits;

use Exception;
use ReflectionClass;

trait AutoHandlerCommand
{
    public function handle()
    {
        try {
            $method = $this->argument('method');

            $methodName = lcfirst((new ReflectionClass($this))->getShortName()) . ucfirst($method);

            if (!method_exists($this, $methodName)) {
                throw new Exception("Method '{$method}' is not defined");
            }

            call_user_func([$this, $methodName]);

            exit;
        } catch (Exception $exception) {
            $this->error("> error: " . $exception->getMessage());

            exit(255);
        }
    }
}
