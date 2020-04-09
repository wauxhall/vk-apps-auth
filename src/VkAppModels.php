<?php

namespace Wauxhall\VkAppsAuth;

use Illuminate\Database\Eloquent\Model;
use Wauxhall\VkAppsAuth\Exceptions\InvalidConfigException;

class VkAppModels
{
    public static $vkapp = 'Wauxhall\VkAppsAuth\Models\VkApp';

    /**
     * @return Model
     */
    public static function vkapp() : Model
    {
        return new static::$vkapp;
    }

    /**
     * @return Model
     * @throws InvalidConfigException
     */
    public static function user() : Model
    {
        $model = config('auth.providers.' . config('auth.guards.api.provider') . '.model');

        if (is_null($model)) {
            throw new InvalidConfigException('Ошибка в конфиге auth.php: невозможно определить модель аутентификации в auth.providers');
        }

        return new $model;
    }
}
