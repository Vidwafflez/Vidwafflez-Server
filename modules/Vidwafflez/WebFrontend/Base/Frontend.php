<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\WebFrontend\Base;

use Vidwafflez\Common\Constants;
use Vidwafflez\Api\Base\Context\ClientName;

/**
 * A base for all web frontends.
 */
abstract class Frontend
{
    /**
     * API context client name to query with.
     * 
     * Behaviour can be coordinated with API clients.
     * The web frontend is responsible for very little of
     * the work, amounting only to the rendering of the page.
     * 
     * This should very rarely be changed after being
     * set.
     */
    const API_CLIENT_NAME = ClientName::UNKNOWN_CLIENT;

    /**
     * API context client version to query with.
     */
    const API_CLIENT_VERSION = "0";

    /**
     * Secret API key to use for private requests.
     * 
     * For serving the duties of a web frontend accessed by many
     * different people, the public API can't really be used.
     * I don't want to be query limited ;(
     */
    const SECRET_API_KEY = "";

    /**
     * Begin rendering a page through the web frontend.
     */
    final public function start(): void
    {
        ob_start();

        $this->route();

        ob_end_flush();
    }

    public function getApiName(): ClientName
    {
        return static::API_CLIENT_NAME;
    }

    public function getApiVersion(): string|int
    {
        return static::API_CLIENT_VERSION;
    }

    public function getApiKey(): string
    {
        return static::SECRET_API_KEY;
    }

    /**
     * Get a new Twig instance.
     * 
     * This method allows for streamlining the Twig boot process,
     * including binding necessary extensions or other things.
     */
    public function getTemplateEngine(string $templatesPath): \Twig\Environment
    {
        $opts = [
            "debug" => (bool)Constants::get("twig_debug")
        ];

        $twig = new \Twig\Environment(
            new \Twig\Loader\FilesystemLoader("frontend/templates/www"),
            $opts
        );

        return $twig;
    }

    /**
     * Route a request URI to its route behaviour handler.
     */
    abstract public function route(): void;
}