<?php

namespace Blume\Foundation\Core;

use Blume\Foundation\Core\Abstracts\ApiNode;
use Blume\Services\ModulesService;
use Illuminate\Support\Collection;

class ModulesResolver extends ApiNode
{
    public function allModules(): Collection
    {
        return (new ModulesService)->storedModules();
    }
}
