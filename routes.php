<?php

use App\Http\Controllers\BicycleController;
use Pecee\Http\Middleware\BaseCsrfVerifier;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::csrfVerifier(new BaseCsrfVerifier());

SimpleRouter::get('/', function() {
    header("Location: /bicycles");
});

SimpleRouter::resource('/bicycles', BicycleController::class);

SimpleRouter::get('/test', [BicycleController::class, 'test']);
