<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Common;

/**
 * Implements a constants manager, generally for handling private
 * keys.
 */
class Constants
{
    private static $cache = [];

    public static function __initStatic()
    {
        self::loadConstants();
    }

    public static function loadConstants()
    {
        $fileName = "config/constants.ini";
        $parsed = parse_ini_file($fileName, true);

        self::$cache = $parsed["vw_constants"];

        return self::$cache;
    }

    public static function get($name)
    {
        return self::$cache[$name];
    }
}