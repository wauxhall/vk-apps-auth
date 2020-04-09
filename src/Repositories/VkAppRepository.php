<?php

namespace Wauxhall\VkAppsAuth\Repositories;

use Wauxhall\VkAppsAuth\Contracts\Repositories\VkAppRepositoryInterface;
use Wauxhall\VkAppsAuth\Exceptions\DecryptFailureException;
use Wauxhall\VkAppsAuth\VkAppModels;

class VkAppRepository implements VkAppRepositoryInterface
{
    /**
     * @param int $app_id
     * @return string
     * @throws DecryptFailureException
     */
    public function getAppSecret(int $app_id) : string
    {
        $app = VkAppModels::vkapp()->query()->where('app_id', $app_id)->first();

        if(!is_null($app)) {
            $secret = vma_decrypt(config('vkapps.app_secret_crypto_key'), $app->client_secret);

            if(!$secret) {
                throw new DecryptFailureException('Не удалось расшифровать client secret приложения (id = ' . $app->app_id . ') по ключу');
            }

            return $secret;
        }

        return '';
    }
}
