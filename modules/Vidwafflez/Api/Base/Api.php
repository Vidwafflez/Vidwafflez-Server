<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Api\Base;

use Exception;

/**
 * Implements base API behaviours.
 * 
 * It is an API for the APIs, sorta. This class is responsible for
 * implementing all common API behaviours, such as resolution,
 * rejection, and validation.
 * 
 * If a behaviour is shared between multiple APIs, it's probably
 * better off here.
 */
class Api
{
    private static string $lastInvalidationReason;

    /**
     * Resolve an API request.
     * 
     * This wraps an API response in a status wrapper in order to
     * report additional information about the API status.
     */
    public static function resolve(object $data): object
    {
        return (object)[
            "status" => "SUCCESS",
            "response" => $data
        ];
    }

    /**
     * Reject an API request.
     * 
     * As the above function does, this returns a status wrapper
     * that signifies that the request as failed. 
     * 
     * In many cases, additional information may be provided such as the 
     * failure reason or a list of errors that occurred during the process.
     */
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
     * 
     * API validation compares the request to a schema, which allows a simple
     * definition to preface an API saying what to use.
     * 
     * The validation functionality only runs a few simple checks on the API,
     * as in no preset behaviour occurs upon an invalidation. Handling of an
     * invalid request is left solely to the API implementation itself.
     * 
     * This function returns a boolean reporting if the request is valid, and
     * if it isn't, additionally updates the last invalidation reason which can
     * be reported by an API rejection or any similar notice. The boolean response
     * allows a clear and concise usage within an if statement:
     * 
     * <code>
     *     if (!Api::validateRequest($schema)) 
     *         return Api::reject(Api::getLastInvalidationReason());
     * </code>
     * 
     * @see ::getLastInvalidationReason() for getting error message upon
     *                                    invalidation
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