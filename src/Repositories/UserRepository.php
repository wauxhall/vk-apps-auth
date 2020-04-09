<?php

namespace Wauxhall\VkAppsAuth\Repositories;

use Wauxhall\VkAppsAuth\Contracts\Repositories\UserRepositoryInterface;
use Wauxhall\VkAppsAuth\Exceptions\InvalidConfigException;
use Wauxhall\VkAppsAuth\Exceptions\MissingDependencyException;
use Wauxhall\VkAppsAuth\VkAppModels;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param string $login_field
     * @param string $value
     * @return array
     * @throws MissingDependencyException
     * @throws InvalidConfigException
     */
    public function getUser(string $login_field, string $value) : array
    {
        $user = VkAppModels::user()->query()->where($login_field, $value)->first();

        if(is_null($user)) {
            return [];
        }

        if(!method_exists($user, 'createToken')) {
            throw new MissingDependencyException('Метод createToken не существует в модели аутентификации. У вас установлен Laravel Passport?');
        }

        return [
            'id' => $user->id,
            'token' => $user->createToken('VK_user_token')->accessToken
        ];
    }

    /**
     * @param array $create_data
     * @return array
     * @throws InvalidConfigException
     * @throws MissingDependencyException
     */
    public function createUser(array $create_data) : array
    {
        $user = VkAppModels::user()->query()->create($create_data);

        if(!method_exists($user, 'createToken')) {
            throw new MissingDependencyException('Метод createToken не существует в модели аутентификации. У вас установлен Laravel Passport?');
        }

        return [
            'id' => $user->id,
            'token' => $user->createToken('VK_user_token')->accessToken
        ];
    }
}
