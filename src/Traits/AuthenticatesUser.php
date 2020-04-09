<?php

namespace Wauxhall\VkMiniAppsAuth\Traits;

use App\Models\User;
use Wauxhall\VkMiniAppsAuth\Validation\LoginValidator;
use Wauxhall\VkMiniAppsAuth\Validation\RegisterValidator;

trait AuthenticatesUser //UserAuthService implements UserAuthInterface
{
    public function login(array $data, LoginValidator $validator)
    {
        $errors = $validator->validate($data)->errors();

        if(!empty($errors)) {
            return false;
        }

        if( ($user = User::where('email', $data['email'])->first()) !== null ) {
            return $this->register($data);
        }

        return $user->createToken('VK_user_token')->accessToken;
    }

    public function register(array $data, RegisterValidator $validator) : bool
    {
        $errors = $validator->validate($data)->errors();

        if(!empty($errors)) {
            return false;
        }

        $input = [
            'name' => 'vk_user_id' . $credentials['vk_user_id'],
            'email' => $credentials['email'],
            'password' => $this->encryptPassword($credentials['vk_user_id'])
        ];

        return User::create($input)->createToken('VK_user_token')->accessToken;
    }

    public function encryptPassword($password) : string
    {
        $salt = empty($s = config('vkminiapps.user_password_salt')) ? $this->createPasswordSalt() : $s;

        return bcrypt($salt . $password . \date('Y-m-d H:i:s'));
    }

    public function createPasswordSalt() : string
    {
        try {
            $salt = random_bytes(12);
        } catch (\Exception $e) {
            return '';
        }

        return (vma_setEnv('VK_MINI_APPS_USER_PASSWORD_SALT', $salt) ? $salt : '');
    }
}
