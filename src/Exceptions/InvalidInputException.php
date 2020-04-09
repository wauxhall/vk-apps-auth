<?php

namespace Wauxhall\VkAppsAuth\Exceptions;

use Exception;
use Wauxhall\VkAppsAuth\Traits\SendResponse;

class InvalidInputException extends Exception
{
    use SendResponse;

    /**
     * Do not report the exception
     */
    public function report()
    {
        //
    }

    public function render()
    {
        return $this->sendError($this->getMessage(), 422);
    }
}
