<?php
// Copyright 2022 Vidwafflez GK.
//
// This file implements early loader procedures, acting
// as the insertion point for the Vidwafflez server.

require "inc/main.php";
use Vidwafflez\Base\AppRouter;
use Vidwafflez\Base\ApiRestRouter;

switch ($_GET["subdomain"])
{
    // Web frontend subdomains
    case "www":
    case "m":
        AppRouter::route(function($uri) {
            switch ($uri[0])
            {
                case "api":
                    ApiRestRouter::handle();
                    break;
                default:
                    echo "Hello world";die();
                    break;
            }
        });
        break;
    // API content subdomain
    case "api":
        AppRouter::route(function($uri) {
            switch ($uri[0])
            {
                case "api":
                    ApiRestRouter::handle();
                    break;
                default:
                    echo "Invalid URL.";
                    break;
            }
        });
        break;
    // Static content subdomain
    case "s":
        break;
    // Dynamic image subdomain
    case "i":
        break;
    // Dynamic video subdomain
    case "v":
        break;
}