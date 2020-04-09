<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth routes for vk apps
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application. These
| routes are loaded by the VkAppsAuthProvider. These routes are used only for requests from VK-applications
|
*/

Route::group([
    'prefix' => 'vk_app',
    'namespace' => 'Wauxhall\VkAppsAuth\Http\Controllers',
    'middleware' => 'vkapps_signed'
], function() {
    Route::post('auth', 'AuthController@auth');
    Route::put('register', 'AuthController@register');
    Route::post('check', 'AuthController@checkRegistered');
});
