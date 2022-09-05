<?php
// Copyright 2022 Vidwafflez GK.
namespace Vidwafflez\Base;

function VidwafflezAutoloader($class)
{
    $filename = str_replace("\\", "/", $class);

    // Scan the file system for the requested module.
    if (file_exists("modules/{$filename}.php"))
    {
        require "modules/{$filename}.php";
    }

    // Implement the fake magic method __initStatic
    // for automatically initialising static classses.
    if (method_exists($class, "__initStatic"))
    {
        $class::__initStatic();
    }
}

spl_autoload_register("Vidwafflez\Base\VidwafflezAutoloader");