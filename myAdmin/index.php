<?php

// Set flag for restricting direct access to other files.
define('DMCCMS', 1);
// load application
require_once("../load.php");

// Load application
Load::loadApplication();

// set parant directory
CFG::$baseDir = UTIL::getBaseDir(__DIR__);
// create an application
APP::createApplication("admin");

?>