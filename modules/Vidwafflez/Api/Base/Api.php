<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Base;

use Exception;

/**
 * Implements base API behaviours.
 */
class Api
{
    private static string $lastInvalidationReason;

    public static function resolve(object $data): object
    {
        return (object)[
            "status" => "SUCCESS",
            "response" => $data
        ];
    }

    public static function reject(string $reason = null, 
                                  array $errors = null): object
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

    /**
     * Validate an API request.
     */
    public static function validateRequest(mixed &$req, array $schema): bool
    {
        // Convert types accordingly
        self::convertRequestType($req);
        if (!is_array($schema)) throw new Exception(
            "API schema must be of type array."
        );

        // Iterate the request properties and validate that
        // non-optional ones are there
        foreach ($schema as $key => $props)
        {
            $exists = isset($req->{$key});
            $optional = $props["optional"] ?? false;

            // Validate types (including "any" special type)
            if (isset($props["type"]))
            {
                $type = $props["type"];

                if ("any" != $type && self::getType($req->{$key}) != $type)
                {
                    self::invalidate("Invalid type for property $key.");
                    return false;
                }
            }

            if (!$exists && !$optional)
            {
                self::invalidate("Request is missing required property $key.");
                return false;
            }
        }

        // If we got to this point, we've succeeded, so respond
        // true.
        return true;
    }

    /**
     * Get the last invalidation reason (for reporting API errors)
     */
    public static function getLastInvalidationReason(): string
    {
        return self::$lastInvalidationReason;
    }

    /**
     * Set the invalidation reason.
     */
    protected static function invalidate(string $reason): void
    {
        self::$lastInvalidationReason = $reason;
    }

    /**
     * Get the type name for type handlers
     */
    protected static function getType(mixed $v): string
    {
        $nativeType = gettype($v);

        switch ($nativeType)
        {
            case "boolean": return "bool";
            case "integer": return "int";
            case "double":  return "float";
            case "NULL":    return "null";
            default:        return $nativeType;
        }
    }

    /**
     * Attempt converting a foreign request type (array from code
     * or JSON string from request) to a native PHP object for
     * handling within in the API.
     */
    protected static function convertRequestType(mixed &$req): object
    {
        if (is_object($req))
        {
            return $req; // Nothing needs to be done
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
                return $req;
            }
        }
    }
}