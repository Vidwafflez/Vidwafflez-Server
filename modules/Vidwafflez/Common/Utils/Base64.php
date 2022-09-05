<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Common\Utils;

class Base64
{
    public static function encode($data)
    {
        return base64_encode($data);
    }

    public static function decode($data)
    {
        return base64_decode($data);
    }

    public static function urlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    }

    public static function urlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    }
}