<?php

namespace Wauxhall\VkAppsAuth\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Wauxhall\VkAppsAuth\Contracts\UserAuthInterface;
use Wauxhall\VkAppsAuth\Http\Requests\LoginRequest;
use Wauxhall\VkAppsAuth\Http\Requests\RegisterRequest;
use Wauxhall\VkAppsAuth\Traits\SendResponse;

class AuthController
{
    use SendResponse;

    protected $auth_logic;

    public function __construct(UserAuthInterface $auth_logic)
    {
        $this->auth_logic = $auth_logic;
    }

    /**
     * Logs-in a user. If the user doesn't exists, automatically redirects request to register route.
     * Can be used for optimization to reduce number of requests by obsoleting user existence check,
     * but you need to pass all the registration data every time
     *
     * @param LoginRequest $login_request
     * @param RegisterRequest $register_request
     * @return JsonResponse
     */
    public function auth(LoginRequest $login_request, RegisterRequest $register_request) : JsonResponse
    {
        $user = $this->auth_logic->login($login_request->all());

        if(empty($user)) {
            return $this->register($register_request);
        }

        return $this->sendResponse($user);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request) : JsonResponse
    {
        $response = $this->auth_logic->register($request->all());

        return $this->sendResponse($response);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function checkRegistered(LoginRequest $request) : JsonResponse
    {
        $user = $this->auth_logic->login($request->all());

        if(empty($user)) {
            return $this->sendResponse([
                'registered' => false
            ]);
        }

        return $this->sendResponse($user);
    }
}
