<?php

// Set flag for restricting direct access to other files.
define('DMCCMS', 1);
// load application
require_once("load.php");
// Load application
Load::loadApplication();

// create an application;	
APP::createApplication();