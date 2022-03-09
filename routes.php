<?php

use App\Http\Controllers\BicycleController;
use App\Http\Controllers\SupplierController;
use Pecee\Http\Middleware\BaseCsrfVerifier;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::csrfVerifier(new BaseCsrfVerifier());

SimpleRouter::get('/', function() {
    header("Location: /bicycles");
});

SimpleRouter::resource('/bicycles', BicycleController::class);
SimpleRouter::resource('/suppliers', SupplierController::class);

SimpleRouter::get('/test', [BicycleController::class, 'test']);
