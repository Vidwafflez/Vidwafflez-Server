<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Common\Utils;

/**
 * A collection of common string transformation utilities
 * that might be useful across the codebase.
 */
class StringUtils
{
    /**
     * Convert a string from camelCase (ClassName and methodName) to
     * snake_case.
     * 
     * @see https://stackoverflow.com/a/19533226
     */
    public static function camelToSnake($str, $sepchar = "_")
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', $sepchar . '$0', $str));
    }

    /**
     * Convert a string from snake_case to camelCase or PascalCase.
     */
    public static function snakeToCamel($str, $pascalCase = false, $sepchar = "_")
    {
        $str = str_replace(" ", "", ucwords(str_replace($sepchar, " ", $str)));

        if (!$pascalCase) {
            $str = lcfirst($str);
        }

        return $str;
    }
}