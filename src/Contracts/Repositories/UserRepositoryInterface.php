<?php

namespace Wauxhall\VkAppsAuth\Contracts\Repositories;

Interface UserRepositoryInterface
{
    /**
     * Get logged-in user if found. Returns an array of: user id and access token
     *
     * @param string $login_field
     * @param string $value
     * @return array
     */
    public function getUser(string $login_field, string $value) : array;

    /**
     * Register a user. Returns an array of: user id and access token
     *
     * @param array $create_data
     * @return array
     */
    public function createUser(array $create_data) : array;
}
