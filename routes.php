<?php

require 'vendor/autoload.php';

use App\Route;

// Defining all routes
Route::resource('patients');
Route::resource('patients.metrics');

// More routes can be added here