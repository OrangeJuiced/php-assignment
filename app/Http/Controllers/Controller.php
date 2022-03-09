<?php

namespace App\Http\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private Environment $twig;

    /**
     * Base controller constructor.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('resources/views');
        $this->twig = new Environment($loader);
    }

    /**
     * Render a view using Twig.
     *
     * @param string $view
     * @param array $data
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(string $view, array $data = [])
    {
        $this->twig->display($view, $data);
    }
}