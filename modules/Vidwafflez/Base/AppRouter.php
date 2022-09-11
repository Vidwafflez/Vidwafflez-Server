<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Base;

/**
 * Implements the main application router.
 */
class AppRouter
{
    protected static array $routes = [];

    public static function route($cb): void
    {
        $cb(self::getUriBase());
    }

    protected static function getUriBase(): array
    {
        $uri = $_SERVER["REQUEST_URI"];
        $uri = explode("/", explode("?", $uri)[0]);
        array_splice($uri, 0, 1);
        
        return $uri;
    }
}