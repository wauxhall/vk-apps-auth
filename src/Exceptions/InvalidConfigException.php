<?php

namespace Wauxhall\VkAppsAuth\Exceptions;

use Exception;
use Wauxhall\VkAppsAuth\Traits\SendResponse;

class InvalidConfigException extends Exception
{
    use SendResponse;

    public function render() {
        return $this->sendError('Произошла ошибка на сервере, связанная неверной конфигурацией. Обратитесь к логам и поправьте конфиги', 500);
    }
}
