<?php

namespace Blume\Foundation;

use Blume\Foundation\Application;

class ConsoleApplication extends Application
{
    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();
    }

    public function path($path = '')
    {
        return $this->joinPaths(realpath($this->appPath ?: $this->basePath('core')), $path);
    }
}
