<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Base;

/**
 * Implements base API behaviours.
 */
class Api
{
    private static $lastInvalidationReason;

    public static function resolve($data)
    {
        return (object)[
            "status" => "SUCCESS",
            "response" => $data
        ];
    }

    public static function reject($reason = null, $errors = null)
    {
        $response = [
            "status" => "FAILED"
        ];

        if (is_string($reason))
        {
            $response += ["reason" => $reason];
        }

        if (is_array($errors))
        {
            $response += ["errors" => $errors];
        }

        return (object)$response;
    }

    public static function validateRequest(&$req, $schema)
    {
        self::convertRequestType($req);
    }

    public static function getLastInvalidationReason()
    {
        return self::$lastInvalidationReason;
    }

    /**
     * Attempt converting a foreign request type (array from code
     * or JSON string from request) to a native PHP object for
     * handling within in the API.
     */
    protected static function convertRequestType(&$req)
    {
        if (is_object($req))
        {
            return; // Nothing needs to be done
        }
        else if (is_array($req))
        {
            $req = (object)$req;
        }
        else if (is_string($req))
        {
            // Attempt JSON decode
            $json = json_decode($req);

            if (false != $json)
            {
                $req = $json;
                return;
            }
        }
    }
}