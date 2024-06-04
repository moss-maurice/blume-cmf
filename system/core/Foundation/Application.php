<?php

namespace Blume\Foundation;

use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication
{
    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();
    }

    public function publicPath($path = '')
    {
        return $this->joinPaths(realpath($this->publicPath ?: $this->basePath('../')), $path);
    }

    public function path($path = '')
    {
        return $this->joinPaths(realpath($this->appPath ?: $this->publicPath('system/core')), $path);
    }
}
