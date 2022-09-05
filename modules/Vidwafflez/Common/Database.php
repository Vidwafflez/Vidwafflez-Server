<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Common;

use PDO;
use ReflectionClass;

/**
 * Implements the common database API used by Vidwafflez.
 */
class Database
{
    private const MAIN_DB_CONFIG_KEY = "main_db_config";
    private const AUTH_DB_CONFIG_KEY = "auth_db_config";

    private static $instances = [];
    private static $mainInstance = null;

    public static function __initStatic()
    {
        $info = self::getDatabaseInfo();

        $main = self::createPdoInstance($info[self::MAIN_DB_CONFIG_KEY]);
        //$auth = self::createPdoInstance($info[self::AUTH_DB_CONFIG_KEY]);

        self::$instances += ["main" => $main];
        //self::$instances += ["auth" => $auth];

        self::$mainInstance = &self::$instances["main"];
    }

    public static function __callStatic($name, $args)
    {
        $i = &self::$mainInstance;

        $reflection = new ReflectionClass($i);
        $className = $reflection->getName();

        if ($reflection->hasMethod($name))
        {
            $method = $reflection->getMethod($name);

            if ($method->isPublic())
            {
                return $method->invoke($i, ...$args);
            }
        }
        else
        {
            throw new \Exception("Method \"$name\" does not exist on class \"$className\".");
        }
    }

    /**
     * @return PDO
     */
    public static function &get($name)
    {
        return self::$instances[$name];
    }

    protected static function createPdoInstance($info)
    {
        // Formulate DSN string for the PDO constructor
        $driver = $info["driver"];
        $hostName = $info["host_name"];
        $hostPort = $info["host_port"];
        $dbName = $info["db_name"];

        $dsn = "$driver:host=$hostName;port=$hostPort;dbname=$dbName;";

        $username = $info["username"];
        $password = $info["password"];

        return new PDO($dsn, $username, $password);
    }

    protected static function insertInstance($name, $i)
    {
        self::$instances += [$name => $i];
    }

    private static function getDatabaseInfo()
    {
        $fileName = "config/db.ini";
        
        $parsed = parse_ini_file($fileName, true);

        return $parsed;
    }
}