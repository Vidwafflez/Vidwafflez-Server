<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Common;

use YukisCoffee\CoffeeController\RequestMetadata;
use YukisCoffee\CoffeeController\Util\DataArray;

/**
 * API for processing the current incoming HTTP request.
 */
class Http
{
    /**
     * An instance of the CoffeeController RequestMetadata
     * component.
     * 
     * Using this here creates some spaghetti code, but it
     * is useful to reuse this code here.
     */
    private static RequestMetadata $metadata;

    public static function __initStatic(): void
    {
        self::$metadata = new RequestMetadata();
    }

    /**
     * Get general metadata about the incoming request.
     */
    public static function getMetadata(): RequestMetadata
    {
        return self::$metadata;
    }

    /**
     * Get the current response status set.
     */
    public static function getResponseStatus(): int
    {
        return \http_response_code();
    }

    /**
     * Set the response status.
     * 
     * This is 200 OK, 404 Not Found, etc.
     */
    public static function setResponseStatus(int $status): void
    {
        \http_response_code($status);
    }

    /**
     * Get the request method.
     */
    public static function getMethod(): string
    {
        return self::$metadata->method;
    }

    /**
     * Get the request path as an indexed array.
     * 
     * @return string[]
     */
    public static function getPath(): array
    {
        return self::$metadata->path;
    }

    /**
     * Get the raw request path.
     * 
     * Unlike the getPath() method, this returns the raw
     * path as requested by the server.
     */
    public static function getRawPath(): string
    {
        return $_SERVER["REQUEST_URI"] ?? "/";
    }

    /**
     * Get the query (request params) as an associative array.
     */
    public static function getQuery(): DataArray
    {
        return self::$metadata->params;
    }

    /**
     * Get the post body (if available).
     * 
     * Per CoffeeController implementation, this will return
     * either a string or an automatically deserialised object
     * from JSON input (given a properly marked Content-Type request
     * header).
     */
    public static function getPostBody(): string|object
    {
        return self::$metadata->body;
    }

    /**
     * Get the incoming content type.
     */
    public static function getContentType(): string
    {
        return strtolower(self::$metadata->headers->contentType ?? "application/octet-stream");
    }

    /**
     * Send a response header.
     */
    public static function sendHeader(string $name, string $value): void
    {
        header("$name: $value");
    }

    /**
     * Set the outgoing content type.
     */
    public static function setContentType(string $type): void
    {
        self::sendHeader("Content-Type", $type);
    }

    /**
     * Hard redirect to another location.
     */
    public static function redirect(string $dest): void
    {
        self::setResponseStatus(302);
        self::sendHeader("Location", $dest);
    }
}