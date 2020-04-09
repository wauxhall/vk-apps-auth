<?php

/*
|--------------------------------------------------------------------------
| Package helper functions
|--------------------------------------------------------------------------
*/

/**
 * Encrypt string with given key via openssl_encrypt
 *
 * @param string $key
 * @param string $message
 * @return string
 */
function vma_encrypt(string $key, string $message) : string
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($message, 'aes-256-cbc', $key, 0, $iv);

    return base64_encode($encrypted . '::' . $iv);
}

/**
 * Decrypt string with given key via openssl_decrypt
 *
 * @param string $key
 * @param string $cipher
 * @return string
 */
function vma_decrypt(string $key, string $cipher) : string
{
    list($encrypted_data, $iv) = explode('::', base64_decode($cipher), 2);

    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

/**
 * Write a value into .env
 *
 * @param string $key
 * @param string $value
 * @return bool
 */
function vma_setEnv(string $key, string $value) : bool
{
    $path = base_path('.env');

    if (file_exists($path)) {
        $content = file_get_contents($path);

        if(env($key, 'doesntexists') !== 'doesntexists') {
            $new_content = str_replace($key . '=' . env($key), $key . '=' . $value, $content);
        } else {
            $new_content = $content . "\n{$key}={$value}\n";
        }

        return boolval( file_put_contents($path, $new_content) );
    }

    return false;
}

/**
 * Generate strong password
 *
 * @param int $length
 * @return string
 * @throws Exception
 */
function vma_generatePassword($length = 32)
{
    return bcrypt(random_bytes($length) . date('Y-m-d H:i:s'));
}
