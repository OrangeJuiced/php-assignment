<?php

namespace App\Http\Controllers;

use App\Models\Bicycle;
use App\Models\Supplier;
use Pecee\SimpleRouter\SimpleRouter;

class BicycleController extends Controller
{
    public function create()
    {
        $model = new Supplier();

        $this->render('bicycles/create.php', [
            'suppliers' => $model->all(),
            'csrf' => SimpleRouter::router()->getCsrfVerifier()->getTokenProvider()->getToken(),
        ]);
    }

    public function store($data)
    {
        dump($_POST);

        $bicycle = new Bicycle();

        $bicycle->create([
            'name' => 'heelleuk',
            'price' => 232323,
            'description' => 'goeie fiets',
        ]);
    }

    public function index()
    {
        $bicycle = new Bicycle();

        $this->render('bicycles/index.php', [
            'bicycles' => $bicycle->all(),
            'csrf' => SimpleRouter::router()->getCsrfVerifier()->getTokenProvider()->getToken(),
        ]);
    }

    public function show(int $id)
    {
        $bicycle = new Bicycle();

        $this->render('bicycles/show.php', [
            'bicycle' => $bicycle->find($id),
        ]);
    }

    public function edit(int $id)
    {
        $bicycle = new Bicycle();

        $this->render('bicycles/edit.php', [
            'bicycle' => $bicycle->find($id),
        ]);
    }

    public function destroy(int $id)
    {
        $bicycle = new Bicycle();

        $bicycle->find($id)->delete();

        header('Location: /');
    }

    public function test()
    {
        $bicycle = new Bicycle();

        $bicycle->create([
            'name' => 'heelleuk',
            'price' => 232323,
            'description' => 'goeie fiets',
        ]);
    }
}