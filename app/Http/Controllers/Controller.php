<?php

namespace App\Http\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('resources/views');
        $this->twig = new Environment($loader);
    }

    public function render(string $view, array $data = [])
    {
        $this->twig->display($view, $data);
    }
}