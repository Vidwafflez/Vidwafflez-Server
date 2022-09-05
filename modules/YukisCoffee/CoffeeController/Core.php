<?php
namespace YukisCoffee\CoffeeController;

/**
 * Implements core behaviours of the CoffeeController
 * architecture.
 * 
 * These behaviours include the storing the common state
 * and template variables. It also provides an API for
 * basic interaction with the system, i.e. importing.
 * 
 * This may also be referred to as CV2, which was an early codename
 * for this project when it was still exclusively a component of
 * the Rehike project.
 * 
 * Controllers are passed one simple $request variable that contains metadata
 * about the request, unless the legacy state and template variables are registered
 * within the core.
 * 
 * @author Taniko Yamamoto <kirasicecreamm@gmail.com>
 * @author The Rehike Maintainers
 * @version 3.0
 */
class Core
{
    /**
     * A single-use function for configuring CoffeeController.
     */
    public static function init($config)
    {
        
    }

    /** 
     * A reference to template state variable.
     * 
     * This variable gets passed to each controller, but
     * modifications exceed it so that closing services
     * may access its contents.
     * 
     * This is only kept around now for historical purposes.
     * 
     * State should ideally be introduced by the controllers
     * themselves.
     * 
     * @deprecated
     * @var object|array
     */
    public static $state = null;

    /** 
     * A reference to the global template file string.
     * 
     * This was mostly useless even with Rehike's own
     * implementation of CoffeeController, but it was useful
     * to keep as a reference during the development of the
     * system.
     * 
     * This is only kept around now for historical purposes.
     * 
     * Template rendering should ideally be done by the
     * controllers themselves.
     * 
     * @deprecated
     * @var string
     */
    public static $template = null;

    /** 
     * Register a state reference. Kept for historical purposes. 
     * 
     * @deprecated
     * @see $state 
     */
    public static function registerStateVariable(&$state)
    {
        self::$state = &$state;
    }

    /** 
     * Register a template reference. Kept for historical purposes.
     * 
     * @deprecated
     * @see $template 
     */
    public static function registerTemplateVariable(&$template)
    {
        self::$template = &$template;
    }

    /**
     * API for getting the legacy state variable.
     */
    public static function &getLegacyStateVariable()
    {
        return self::$state;
    }

    /**
     * API for getting the legacy template variable.
     */
    public static function &getLegacyTemplateVariable()
    {
        return self::$template;
    }

    /**
     * Import a controller's file or pull it from the session
     * cache.
     * 
     * The contents are cached in order to allow reimports without
     * causing additional errors, such as in the event of a
     * function redeclaration.
     * 
     * @return GetControllerInstance
     */
    public static function import($controllerName, $appendPhp = true)
    {
        if (ControllerStore::hasController($controllerName))
        {
            // Import from cache
            $controller = ControllerStore::getController($controllerName);

            return new GetControllerInstance($controllerName, $controller);
        }
        else
        {
            // Import from file (or die)
            $imports = require $controllerName . ($appendPhp ? ".php" : "");

            ControllerStore::registerController($controllerName, $imports);

            return new GetControllerInstance($controllerName, $imports);
        }
    }

    /**
     * @see CallbackStore::setRedirectHandler
     */
    public static function setRedirectHandler($cb)
    {
        return CallbackStore::setRedirectHandler($cb);
    }
}