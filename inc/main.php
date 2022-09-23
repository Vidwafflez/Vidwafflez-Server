<?php
// Copyright 2022 Vidwafflez GK.
/**
 * A general import script for the Vidwafflez base service.
 * 
 * This controls the most basic behaviours used by all Vidwafflez
 * components, such as the autoloader and project-wide constants.
 */
(include "modules/composer/autoload.php") or die("Run composer before running server.");
require "autoloader.php";