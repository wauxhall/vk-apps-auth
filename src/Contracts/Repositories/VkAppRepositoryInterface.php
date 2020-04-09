<?php

namespace Wauxhall\VkAppsAuth\Contracts\Repositories;

Interface VkAppRepositoryInterface
{
    /**
     * Retrieve vk app's client secret by its id
     *
     * @param int $app_id
     * @return string
     */
    public function getAppSecret(int $app_id) : string;
}
