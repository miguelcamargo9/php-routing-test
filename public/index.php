<?php

require '../vendor/autoload.php';
require '../routes.php';

use App\Route;

// Capture the HTTP method and URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Resolve the route
$response = Route::resolve($method, $uri);

// Set the content type to JSON
echo $response;
