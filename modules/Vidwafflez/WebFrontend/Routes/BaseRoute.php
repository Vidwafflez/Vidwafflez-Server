<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\WebFrontend\Routes;

use Vidwafflez\WebFrontend\Base\Frontend;
use YukisCoffee\CoffeeController\RequestMetadata;

abstract class BaseRoute
{
    protected Frontend $controller;

    final public function __construct(Frontend $binding)
    {
        $this->controller = &$binding;
    }

    final public function getController(): Frontend
    {
        return $this->controller;
    }

    public function get(RequestMetadata $request): void
    {

    }
}