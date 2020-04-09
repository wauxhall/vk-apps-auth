<?php

namespace Wauxhall\VkAppsAuth\Exceptions;

use Exception;
use Wauxhall\VkAppsAuth\Traits\SendResponse;

class MissingDependencyException extends Exception
{
    use SendResponse;

    public function render() {
        return $this->sendError('Отсутствует зависимость в проекте, детали смотрите в логах', 500);
    }
}
