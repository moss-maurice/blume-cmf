<?php

namespace Blume\Services;

use Blume\Foundation\Core\Traits\NodesRegistrator;

class CoreService
{
    use NodesRegistrator;

    public function name()
    {
        return 'Blume';
    }

    public function version()
    {
        return '0.0.1';
    }
}
