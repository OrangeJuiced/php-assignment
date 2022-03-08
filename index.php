<?php

use Dotenv\Dotenv;
use Pecee\SimpleRouter\SimpleRouter;

require_once('vendor/autoload.php');
require_once('routes.php');

Dotenv::createImmutable(__DIR__)->load();

SimpleRouter::start();