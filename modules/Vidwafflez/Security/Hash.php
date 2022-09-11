<?php
namespace Vidwafflez\Security;

class Hash
{
    /**
     * Calculate the SHA1 hash of a string.
     * 
     * Proxy for PHP's standard sha1 for convenience of maintanence,
     * i.e. if a polyfill must be implemented.
     */
    public static function sha1(string $data, bool $binary = false): string
    {
        return sha1($data, $binary);
    }
}