<?php

namespace Blume\Exceptions;

use Exception;

class CoreException extends Exception
{
    protected $customData;

    public function __construct($message = '', $customData = [], $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->customData = $customData;
    }

    public function getCustomData()
    {
        return $this->customData;
    }
}
