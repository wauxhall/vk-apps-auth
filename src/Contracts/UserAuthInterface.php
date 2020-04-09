<?php

namespace Wauxhall\VkAppsAuth\Contracts;

Interface UserAuthInterface
{
    /**
     * Login user. Accepts array of credentials. Returns an array of: user id and access token
     *
     * @param array $login_data
     * @return array
     */
    public function login(array $login_data) : array;


    /**
     * Register user. Accepts an array with registration data. Returns an array of: user id and access token
     *
     * @param array $register_data
     * @return array
     */
    public function register(array $register_data) : array;
}
