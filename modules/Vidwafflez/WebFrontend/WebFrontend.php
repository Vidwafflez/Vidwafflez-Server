<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\WebFrontend;

use Vidwafflez\WebFrontend\Base\Frontend;
use Vidwafflez\Api\Clients\WebClient;

use YukisCoffee\CoffeeController\Core as Controller;
use YukisCoffee\CoffeeController\Router as Router;

use Vidwafflez\WebFrontend\Routes\{
    HomeRoute
};

/**
 * Implements the main web frontend, found at www.vidwafflez.com.
 * 
 * The web frontend is responsible for delivering content
 * to a user via a web browser, rather than a dedicated application
 * as is preferred for mobile devices.
 * 
 * All that it should do is handle routing and rendering of information
 * to a web interchange format (i.e. HTML, JSON, XML). Information itself
 * shall be queried from a central API. No API behaviours should be
 * implemented in this project.
 * 
 * The web frontend works in a few basic steps:
 * 
 *    1. Process the request.
 *        1a. This involves processing the requested URI and finding out
 *            what it wants (home, profile, post, etc.).
 *        1b. Said information is then fed to the API and sometimes the
 *            template engine in order to customise the resulting page
 *            with said data.
 *    2. Render the page.
 *        2a. The rendering process uses a variant of the Twig template engine.
 *            Templates can be found in the `frontend/templates` directory.
 *        2b. Preferably, modifications to the API result shall not be
 *            performed between these two steps.
 *        2c. Rendering can entail multiple different exchange formats, but
 *            the most likely candidate is HTML.
 *        2d. Foreign resources are accessed at this step, such as retrieving
 *            static resource URLs.
 *    3. Send the result.
 *        3a. For the purposes of a web frontend, we want to avoid caching or
 *            use it only minimally. Long-term caching will freeze the results
 *            of the service for the user.
 * 
 * Optimisations shall be applied to the web frontend as needed. For example,
 * menus hidden behind user action can be downloaded as separate elements
 * later. This limits the load on the server and makes the site appear faster
 * for the user.
 */
class WebFrontend extends Frontend
{
    /** @inheritdoc */
    const API_CLIENT_NAME = WebClient::CLIENT_NAME;
    const API_CLIENT_VERSION = WebClient::CLIENT_VERSION;
    const SECRET_API_KEY = "";

    public function route(): void
    {
        Router::get([
            "/" => new HomeRoute($this)
        ]);
    }
}