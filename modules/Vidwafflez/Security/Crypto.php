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
    public static function encrypt($data, $algo, $pass, $options = 0, $iv = "", &$tag = null, $aad = "", $taglen = 16)
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
    public static function decrypt($data, $algo, $pass, $options = 0, $iv = "", &$tag = null, $aad = "")
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

    public static function encryptVideoId($id)
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

    public static function decryptVideoId($id)
    {
        return self::decrypt(
            Base64::urlDecode($id), 
            "DES-EDE3", 
            Constants::get("video_id_encryption_key"), 
            OPENSSL_RAW_DATA
        );
    }

    public static function encryptChannelId($id)
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

    public static function decryptChannelId($id)
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