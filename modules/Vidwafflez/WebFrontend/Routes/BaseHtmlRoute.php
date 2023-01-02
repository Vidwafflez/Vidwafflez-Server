<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\WebFrontend\Routes;

use Vidwafflez\WebFrontend\Base\Frontend;
use Vidwafflez\WebFrontend\WebFrontend;
use Vidwafflez\WebFrontend\MobileFrontend;

use YukisCoffee\CoffeeController\RequestMetadata;

/**
 * 
 */
abstract class BaseHtmlRoute extends BaseRoute
{
    protected \Twig\Environment $twig;
    protected string $template;

    public function get(RequestMetadata $request): void
    {
        parent::get($request);

        $this->template = $this->determineDefaultTemplate();

        // Initialise Twig
        $this->twig = $this->getController()->getTemplateEngine($this->template);
    }

    protected function renderPage(array $context): string
    {
        return $this->twig->render($this->template, $context);
    }

    protected function determineDefaultTemplate(): string
    {
        $controller = $this->getController();

        if ($controller instanceof WebFrontend)
        {
            return "templates/www/base.twig";
        }
        else if ($controller instanceof MobileFrontend)
        {
            return "templates/mobile/base.twig";
        }
    }
}