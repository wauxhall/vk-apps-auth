<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Env file edit permission
    |--------------------------------------------------------------------------
    |
    | Package can generate some values automatically, such as password salt, or encryption key.
    | If you don't want it to write the values to your .env automatically, set this option to false.
    | Also, if you disable it, don't forget to set all important data manually through this config.
    |
    */

    'allow_env_edit' => true,

    /*
    |--------------------------------------------------------------------------
    | Vk client secret crypto key
    |--------------------------------------------------------------------------
    |
    | This value used for encrypting and decrypting your vk app client secret.
    | This is necessary to keep your secret safe in database.
    | Encrypting uses openssl functions with aes-256-cbc cipher method.
    |
    */

    'app_secret_crypto_key' => env('VK_APPS_CLIENT_SECRET_CRYPTO_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Vk app client secret crypto key length
    |--------------------------------------------------------------------------
    |
    | This value is used for automatic generation.
    |
    */

    'app_secret_crypto_key_length' => 32,

    /*
    |--------------------------------------------------------------------------
    | Register user fields
    |--------------------------------------------------------------------------
    |
    | This is the array of fields, that you need to fill in your `users` table while registering a user.
    | Keys are http query parameter names.
    | db_column_name helps to map given param to the column in database.
    | validation_rule_key is a key to determine what validation rule must be applied to the field. Can be null - it means no validation needed.
    | If you use custom request classes, you can also use this field for defining a necessary rule.
    | Validation comes through FormRequest classes.
    |
    */

    'register_fields' => [
        'name' => [
            'db_column_name' => 'name',
            'validation_rule_key' => 'name'
        ],
        'email' => [
            'db_column_name' => 'email',
            'validation_rule_key' => 'email'
        ],

        /*
        |
        | Here come your custom fields you want to use while registering a user, e.g.
        |
        | 'phone' => [
        |    'db_column_name' => 'telephone',
        |    'validation_rule_key' => 'phone'
        | ],
        |
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Login field
    |--------------------------------------------------------------------------
    |
    | This value specifies, what field to use as login. Must be the same as one of the keys of "register_fields" parameter.
    |
    */

    'login_field' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Password field name in database
    |--------------------------------------------------------------------------
    |
    | This value is the password column name in your database.
    |
    */

    'password_db_field_name' => 'password',

    /*
    |--------------------------------------------------------------------------
    | User generated password length
    |--------------------------------------------------------------------------\
    |
    | This value is used for automatic user's password generation.
    |
    */

    'password_length' => 32,

];
