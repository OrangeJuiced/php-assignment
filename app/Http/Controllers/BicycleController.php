<?php

namespace App\Http\Controllers;

use App\Actions\Bicycle\CreateBicycleAction;
use App\Actions\Bicycle\DeleteBicycleAction;
use App\Actions\Bicycle\UpdateBicycleAction;
use App\Models\Bicycle;
use App\Models\BicycleSupplier;
use App\Models\Supplier;
use Pecee\SimpleRouter\SimpleRouter;

class BicycleController extends Controller
{
    /**
     * Show the create bicycle page.
     *
     * @return void
     */
    public function create(): void
    {
        $supplier = new Supplier();

        $this->render('bicycles/create.php', [
            'suppliers' => $supplier->all(),
            'csrf' => SimpleRouter::router()->getCsrfVerifier()->getTokenProvider()->getToken(),
        ]);
    }

    /**
     * Store a new bicycle in the database.
     *
     * @return void
     */
    public function store(): void
    {
        $action = new CreateBicycleAction();

        $action->execute($_POST);

        header('Location: /');
    }

    /**
     * List all bicycles.
     *
     * @return void
     */
    public function index(): void
    {
        $bicycle = new Bicycle();

        $this->render('bicycles/index.php', [
            'bicycles' => array_key_exists('search', $_GET) ? $bicycle->newQuery()->where('model', 'LIKE', '%' . $_GET['search'] . '%')->get() : $bicycle->all(),
            'csrf' => SimpleRouter::router()->getCsrfVerifier()->getTokenProvider()->getToken(),
            'search' => $_GET['search'] ?? '',
        ]);
    }

    /**
     * Show the edit bicycle page.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $bicycleModel = new Bicycle();
        $bicycleSuppliersModel = new BicycleSupplier();
        $supplierModel = new Supplier();

        $bicycle = $bicycleModel->find($id);

        $supplierIDs = [];

        foreach ($bicycleSuppliersModel->newQuery()->where('bicycle_id', '=', $bicycle->id)->leftJoin('suppliers', 'supplier_id', 'id')->get('suppliers.id') as $supplier) {
            $supplierIDs[] = $supplier->id;
        }

        $this->render('bicycles/edit.php', [
            'bicycle' => $bicycle,
            'suppliers' => $supplierModel->all(),
            'active_suppliers' => $supplierIDs,
            'csrf' => SimpleRouter::router()->getCsrfVerifier()->getTokenProvider()->getToken(),
        ]);
    }

    /**
     * Update an existing bicycle.
     *
     * @param int $id
     * @return void
     */
    public function update(int $id): void
    {
        $action = new UpdateBicycleAction();

        $action->execute($id, $_POST);

        header("Location: /");
    }

    /**
     * Destroy a bicycle.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        $action = new DeleteBicycleAction();

        $action->execute($id);

        header('Location: /');
    }
}