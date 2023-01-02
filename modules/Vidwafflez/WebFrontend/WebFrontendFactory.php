<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\WebFrontend;

use Vidwafflez\WebFrontend\Base\Frontend;

/**
 * Simple wrapper class for getting a web frontend
 * type from a string, i.e. subdomain.
 */
class WebFrontendFactory
{
    /**
     * Get a web frontend controller from its subdomain.
     * 
     * This will return
     * 
     *     - WebFrontend for www.vidwafflez
     *     - MobileFrontend for m.vidwafflez
     * 
     * @return Base class pointer (as string)
     */
    public static function get(string $subdomain): Frontend
    {
        switch ($subdomain)
        {
            case "m": return new MobileFrontend();
            default: return new WebFrontend();
        }
    }
}