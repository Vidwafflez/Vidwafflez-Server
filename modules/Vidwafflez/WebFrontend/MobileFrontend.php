<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\WebFrontend;

use Vidwafflez\Api\Base\Context\ClientName;

/**
 * Implements the mobile web frontend controller.
 * 
 * This is used if the user agent reports a mobile device
 * or if manually chosen by the end user. The mobile frontend
 * is a touch-friendly alternative to the primary web frontend,
 * which is meant to be used with a keyboard and/or mouse.
 * 
 * Due to the similarities with the main web frontend, this directly
 * extends that instead of reimplementing its features by extending
 * the Base.
 * 
 * The same principles that apply to the main web frontend apply here.
 * If you're unaware, please read the documentation for WebFrontend
 * as well.
 */
class MobileFrontend extends WebFrontend
{
    /** @inheritdoc */
    const API_CLIENT_NAME = ClientName::MWEB;
    const API_CLIENT_VERSION = "1";
    const SECRET_API_KEY = "";
}