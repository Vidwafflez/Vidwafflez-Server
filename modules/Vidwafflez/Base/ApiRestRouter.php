<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Base;

use Vidwafflez\Common\Utils\StringUtils;
use YukisCoffee\CoffeeController\RequestMetadata;
use ReflectionClass;

/**
 * Implements the main REST API router, which can be accessed
 * through HTTP.
 */
class ApiRestRouter
{
    /**
     * Called automatically when an API is requested
     * via HTTP.
     */
    public static function handle(): void
    {
        $request = new RequestMetadata();

        if ("POST" != $request->method)
        {
            echo "The request method $request->method is not supported by this server. Sorry about that.";
            return;
        }

        header("Content-Type: application/json");

        if ("application/json" != $request->headers->contentType)
        {
            echo "Unsupported content type.";
            die();
        }

        if ("api" == strtolower($request->path[0]))
        {
            // Api, V1, ApiName, actionName
            if (4 == count($request->path))
            {
                $path = $request->path;
                $action = array_splice($path, -1)[0];

                $apiClass = self::getCorrespondingClass(
                    $path
                );

                $action = StringUtils::snakeToCamel($action, false);
            }
            // Api, V1, ApiName
            else if (3 == count($request->path))
            {
                $apiClass = self::getCorrespondingClass(
                    $request->path
                );

                $action = "default";
            }
        }

        $reflection = new ReflectionClass($apiClass);

        if ($reflection->hasMethod($action))
        {
            $actionMethod = $reflection->getMethod($action);
            
            if (!$actionMethod->isPublic())
            {
                // error
            }

            $response = $actionMethod->invoke(null, $request->body);

            if (isset($response->response) && "SUCCESS" == @$response->status)
            {
                http_response_code(200);
                $response = $response->response;
            }
            else if ("FAILED" == @$response->status)
            {
                http_response_code(400);
            }
            else
            {
                http_response_code(500);
            }

            echo json_encode($response);
        }
    }

    /**
     * Get the corresponding class of the request URI.
     * 
     * @param array $path
     */
    protected static function getCorrespondingClass(array $path): string
    {
        $guard = "Vidwafflez\\Api\\V1";

        $className = "Vidwafflez";
        foreach ($path as $segment)
        {
            $className .= "\\" . StringUtils::snakeToCamel($segment, true);
        }

        // Validate this is only accessing within the approved
        // range.
        if (0 != stripos($className, $guard))
        {
            throw new \Exception("API does not exist or is not permissible to access.");
        }

        if (class_exists($className, true))
        {
            $reflection = new ReflectionClass($className);

            if ($reflection->isAbstract())
            {
                throw new \Exception("API does not exist or is not permissible to access.");
            }

            return $className;
        }
        else
        {
            throw new \Exception("API does not exist or is not permissible to access.");
        }
    }
}