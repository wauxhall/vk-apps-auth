<?php

namespace Wauxhall\VkAppsAuth\Services;

use Exception;
use Wauxhall\VkAppsAuth\Contracts\Repositories\UserRepositoryInterface;
use Wauxhall\VkAppsAuth\Contracts\UserAuthInterface;

class UserAuthService implements UserAuthInterface
{
    protected $repositories = [];

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->repositories['user_repository'] = $user_repository;
    }

    /**
     * @param array $login_data
     * @return array
     */
    public function login(array $login_data) : array
    {
        $column_name = config('vkapps.register_fields.' . config('vkapps.login_field') . '.db_column_name', '');

        return $this->repositories['user_repository']->getUser($column_name, $login_data[config('vkapps.login_field')]);
    }

    /**
     * @param array $register_data
     * @return array
     * @throws Exception
     */
    public function register(array $register_data) : array
    {
        $create_data = [];

        foreach(config('vkapps.register_fields') as $key => $field) {
            if(!empty($register_data[$key])) {
                $create_data[$field['db_column_name']] = $register_data[$key];
            }
        }

        $create_data[ config('vkapps.password_db_field_name') ] = vma_generatePassword(config('vkapps.password_length'));

        return $this->repositories['user_repository']->createUser($create_data);
    }
}
