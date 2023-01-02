<?php
namespace SimpleTemplater
{

class SimpleTemplater
{
    /**
     * Simple loader stub to work around PHP limitations.
     * 
     * You need to run this function in order to import
     * the "use" namespace.
     */
    public static function init() {}
}

}

namespace use_simpletemplater
{

/**
 * Echo a variable (escaped).
 * 
 * @param mixed $var
 * @return string
 */
function e(&$var)
{
    if (isset($var))
    {
        switch (\gettype($var))
        {
            case "string":
                echo htmlspecialchars($var);
                break;
            case "integer":
                echo $var;
                break;
            case "double":
                echo sprintf("%.3F", $var);
                break;
            case "boolean":
                echo $var ? "true" : "false";
                break;
        }
    }

    // Users may call with <?= tag, which is standard
    // short echo. So don't echo twice and handle this
    // correctly.
    return "";
}

/**
 * Echo a variable (raw).
 * 
 * This can be used to, for example, echo a HTML string
 * buffer from memory. Take caution of course.
 * 
 * @param mixed $var
 * @return string
 */
function eRaw(&$var)
{
    if (isset($var))
    {
        switch (\gettype($var))
        {
            case "string":
                echo $var;
                break;
            default:
                return e($var);
        }
    }

    return "";
}

}