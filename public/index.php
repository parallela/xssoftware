<?php
// Base application path const
const BASE_PATH = __DIR__ . '/../';

// Autoload path const
const AUTO_LOAD_PATH = '/vendor/autoload.php';

//Require the base autoloader for needed packages.
require_once BASE_PATH . AUTO_LOAD_PATH;

// Override the $_POST global when we communicate through json api.
$_POST = json_decode(file_get_contents("php://input"), true);

// init the core routes
$route = new App\Core\Route();

// Include the specified routes
require_once BASE_PATH . '/app/routes.php';

$route->init();
