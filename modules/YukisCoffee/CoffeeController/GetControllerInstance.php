<?php
namespace YukisCoffee\CoffeeController;

use ReflectionMethod;

/**
 * Implements a wrapper for working with imported controllers.
 * 
 * @author Taniko Yamamoto <kirasicecreamm@gmail.com>
 * @author The Rehike Maintainers
 */
class GetControllerInstance
{
    /** @var string */
    private $controllerName;
    /** @var object */
    private $boundController;
    
    /** Reference to shorten code. @var string */
    const wrap = "_cv2WrappedCallControllerMethod";

    public function __construct($name, $binding)
    {
        $this->controllerName = &$name;
        $this->boundController = &$binding;
    }

    /**
     * Wrap a method call.
     * 
     * This allows the calling of static methods through this,
     * and also throws an exception if the method does not exist.
     * 
     * @param string $name
     * @param mixed[] $args
     * @return mixed
     */
    protected function _cv2WrappedCallControllerMethod($name, $args)
    {
        /*
         * Get arguments to pass to the method call.
         * 
         * This behaviour does rely on the user's ability to follow
         * basic conventions.
         * 
         * The global state and template behaviours are kept for legacy
         * reasons and should not be used in new projects.
         */
        $passedArgs = [];

        if (null != ($state = Core::getLegacyStateVariable()))
        {
            $passedArgs[] = $state;
        }

        if (null != ($template = Core::getLegacyTemplateVariable()))
        {
            $passedArgs[] = $template;
        }

        array_merge($passedArgs, $args);

        // Check if the method exists in the bound controller
        if (method_exists($this->boundController, $name))
        {
            // Invoke the method
            $method = new ReflectionMethod($this->boundController, $name);

            return $method->invoke($this->boundController, $passedArgs);
        }
        else
        {
            throw new Exception\MethodDoesNotExistException(
                "Called method \"{$name}\" does not exist on bound controller " .
                "\"{$this->controllerName}\"."
            );
        }
    }

    /**
     * Redirect any call to this object to the wrapper.
     * 
     * @param string $name
     * @param mixed[] $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        return $this->{self::wrap}($name, $args);
    }
}