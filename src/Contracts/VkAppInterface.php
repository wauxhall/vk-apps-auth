<?php

namespace Wauxhall\VkAppsAuth\Contracts;

Interface VkAppInterface
{
    /**
     * Get app id from given query parameters
     *
     * @param array $query_params
     * @return int
     */
    public function retrieveAppId(array $query_params) : int;

    /**
     * Get application sign from given query parameters
     *
     * @param array $query_params
     * @return string
     */
    public function retrieveAppSign(array $query_params) : string;

    /**
     * Get the client secret of requesting vk app
     *
     * @param int $app_id
     * @return string
     */
    public function getAppSecret(int $app_id) : string;

    /**
     * Sign validation algorithm
     *
     * @param array $query_params
     * @return bool
     */
    public function validateAppSign(array $query_params) : bool;
}
