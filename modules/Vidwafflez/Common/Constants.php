<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Common;

/**
 * Implements a constants manager, generally for handling private
 * keys.
 */
class Constants
{
    private static array $cache = [];

    public static function __initStatic(): void
    {
        self::loadConstants();
    }

    public static function loadConstants(): array
    {
        $fileName = "config/constants.ini";
        $parsed = parse_ini_file($fileName, true);

        self::$cache = $parsed["vw_constants"];

        return self::$cache;
    }

    public static function get(string $name): mixed
    {
        return self::$cache[$name];
    }
}