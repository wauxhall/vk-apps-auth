<?php

namespace Wauxhall\VkAppsAuth\Services;

use Wauxhall\VkAppsAuth\Contracts\VkAppInterface;
use Wauxhall\VkAppsAuth\Contracts\Repositories\VkAppRepositoryInterface;
use Wauxhall\VkAppsAuth\Exceptions\InvalidInputException;

class VkAppService implements VkAppInterface
{
    private $repositories = [];

    public function __construct(VkAppRepositoryInterface $vk_app_repository)
    {
        $this->repositories['vk_app_repository'] = $vk_app_repository;
    }

    /**
     * @param array $query_params
     * @return int
     * @throws InvalidInputException
     */
    public function retrieveAppId(array $query_params) : int
    {
        if(empty($query_params['vk_app_id'])) {
            throw new InvalidInputException('В переданных параметрах отсутствует id vk-приложения!');
        }

        return intval($query_params['vk_app_id']);
    }

    /**
     * @param array $query_params
     * @return string
     * @throws InvalidInputException
     */
    public function retrieveAppSign(array $query_params) : string
    {
        if(empty($query_params['sign'])) {
            throw new InvalidInputException('В переданных параметрах отсутствует подпись vk-приложения!');
        }

        return $query_params['sign'];
    }

    /**
     * @param int $app_id
     * @return string
     */
    public function getAppSecret(int $app_id) : string
    {
        return $this->repositories['vk_app_repository']->getAppSecret($app_id);
    }

    /**
     * @param array $query_params
     * @return bool
     * @throws InvalidInputException
     */
    public function validateAppSign(array $query_params) : bool
    {
        $sign = $this->retrieveAppSign($query_params);
        $app_id = $this->retrieveAppId($query_params);
        $client_secret = $this->getAppSecret($app_id);

        $sign_params = [];

        foreach ($query_params as $name => $value) {
            if (strpos($name, 'vk_') !== 0) { // Получаем только vk параметры из query
                continue;
            }

            $sign_params[$name] = $value;
        }

        if(empty($sign_params)) {
            throw new InvalidInputException('Не передано ни одного vk_ параметра! Обратитесь к документации VK Mini Apps за помощью');
        }

        ksort($sign_params); // Сортируем массив по ключам

        $sign_params_query = http_build_query($sign_params); // Формируем строку вида "param_name1=value&param_name2=value"

        $generated_sign = rtrim(strtr(base64_encode(hash_hmac('sha256', $sign_params_query, $client_secret, true)), '+/', '-_'), '='); // Получаем хеш-код от строки, используя защищеный ключ приложения. Генерация на основе метода HMAC.

        return $generated_sign === $sign; // Сравниваем полученную подпись со значением параметра 'sign'
    }
}
