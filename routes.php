<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Route;

/**
 * Instantiate the router and register your REST resources.
 * Return it so that public/index.php (or any front-controller)
 * can receive the instance ready to handle requests.
 */
$router = (new Route())
    ->resource('patients')
    ->resource('patients.metrics');

return $router;
