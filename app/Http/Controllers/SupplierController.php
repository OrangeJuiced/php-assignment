<?php

namespace App\Http\Controllers;

class SupplierController extends Controller
{
    public function create()
    {

    }

    public function store()
    {

    }

    public function index()
    {
        $this->render('index.php', [
            'data' => 'jo',
        ]);
    }

    public function show(int $id)
    {
        dump($id);
    }

    public function destroy()
    {

    }
}