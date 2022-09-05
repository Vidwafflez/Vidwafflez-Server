<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Base;

/**
 * Implements the main application router.
 */
class AppRouter
{
    protected static $routes = [];

    public static function route($cb)
    {
        $cb(self::getUriBase());
    }

    // TODO(tyamamoto): Unused?
    protected static function getUriBase()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $uri = explode("/", explode("?", $uri)[0]);
        array_splice($uri, 0, 1);
        
        return $uri;
    }
}