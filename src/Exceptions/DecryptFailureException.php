<?php

namespace Wauxhall\VkAppsAuth\Exceptions;

use Exception;
use Wauxhall\VkAppsAuth\Traits\SendResponse;

class DecryptFailureException extends Exception
{
    use SendResponse;

    public function render() {
        return $this->sendError('Произошла ошибка на сервере, связанная с шифрованием. Обратитесь к логам', 500);
    }
}
