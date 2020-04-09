<?php

namespace Wauxhall\VkAppsAuth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Wauxhall\VkAppsAuth\Contracts\VkAppInterface;
use Wauxhall\VkAppsAuth\Exceptions\InvalidInputException;

class CheckIsRequestFromRegisteredApp
{
    protected $vk_app_service;

    public function __construct(VkAppInterface $vk_app_service)
    {
        $this->vk_app_service = $vk_app_service;
    }
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidInputException
     */
    public function handle($request, Closure $next)
    {
        if($this->vk_app_service->validateAppSign($request->all()) === false) {
            throw new InvalidInputException('Запрос не из доверенного источника отклонен');
        }

        return $next($request);
    }
}
