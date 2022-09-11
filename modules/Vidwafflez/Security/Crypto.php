<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Security;

use Vidwafflez\Common\Constants;
use Vidwafflez\Common\Utils\Base64;

class Crypto
{
    /**
     * An error-checked wrapper for openssl encrypt.
     */
    public static function encrypt(string $data, string $algo, string $pass, int $options = 0, 
                                   string $iv = "", &$tag = null, string $aad = "", 
                                   int $taglen = 16): string
    {
        $result = openssl_encrypt($data, $algo, $pass, $options, $iv, $tag, $aad, $taglen);

        if (false == $result)
        {
            
        }
        else
        {
            return $result;
        }
    }

    /**
     * An error-checked wrapper for openssl decrypt.
     */
    public static function decrypt(string $data, string $algo, string $pass, int $options = 0, 
                                   string $iv = "", &$tag = null, string $aad = ""): string
    {
        $result = openssl_decrypt($data, $algo, $pass, $options, $iv, $tag, $aad);

        if (false == $result)
        {

        }
        else
        {
            return $result;
        }
    }

    public static function encryptVideoId(int|string $id): string
    {
        return Base64::urlEncode(
            self::encrypt(
                $id, 
                "DES-EDE3", 
                Constants::get("video_id_encryption_key"), 
                OPENSSL_RAW_DATA
            )
        );
    }

    public static function decryptVideoId(int|string $id): string
    {
        return self::decrypt(
            Base64::urlDecode($id), 
            "DES-EDE3", 
            Constants::get("video_id_encryption_key"), 
            OPENSSL_RAW_DATA
        );
    }

    public static function encryptChannelId(int|string $id): string
    {
        return Base64::urlEncode(
            self::encrypt(
                $id, 
                "aes-128-cbc", 
                Constants::get("channel_id_encryption_key"), 
                OPENSSL_RAW_DATA, 
                Constants::get("channel_id_encryption_iv")
            )
        );
    }

    public static function decryptChannelId(int|string $id): string
    {
        return self::decrypt(
            Base64::urlDecode($id), 
            "aes-128-cbc", 
            Constants::get("channel_id_encryption_key"), 
            OPENSSL_RAW_DATA, 
            Constants::get("channel_id_encryption_iv")
        );
    }
}