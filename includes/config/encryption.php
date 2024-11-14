<?php

namespace Includes\Config;

class Encryption
{
    private $key;
    private $cipher;

    public function __construct($key)
    {
        $this->key = $key;
        $this->cipher = "aes-128-cbc"; // Choose your cipher
    }

    public function encrypt($data)
    {
        // Generate a random Initialization Vector (IV)
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);

        // Encrypt the data
        $encryptedData = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);

        // Return the encrypted data
        return base64_encode($iv . $encryptedData); // Combine IV and encrypted data for later use
    }

    public function decrypt($data)
    {
        // Decode the base64 encoded data
        $data = base64_decode($data);

        // Extract the IV from the data
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $ivLength);
        $encryptedData = substr($data, $ivLength);

        // Decrypt the data
        return openssl_decrypt($encryptedData, $this->cipher, $this->key, 0, $iv);
    }
}
