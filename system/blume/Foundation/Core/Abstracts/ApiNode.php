<?php

namespace Blume\Foundation\Core\Abstracts;

use Blume\Foundation\Core\Interfaces\ApiDefinitionInterface;
use Blume\Foundation\Core\Traits\NodesMethodsRegistrator;

abstract class ApiNode implements ApiDefinitionInterface
{
    use NodesMethodsRegistrator;
}
