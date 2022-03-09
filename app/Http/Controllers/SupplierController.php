<?php

namespace App\Http\Controllers;

use App\Helpers\DB;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * List all suppliers with their bicycle models.
     *
     * @return void
     */
    public function index()
    {
        $db = new DB(Supplier::class);

        $result = $db->rawQuery("SELECT s.name AS name, s_bicycles.bicycle_model as models FROM suppliers s LEFT JOIN (SELECT GROUP_CONCAT(DISTINCT b.model SEPARATOR ', ') as bicycle_model, bs.bicycle_id, bs.supplier_id FROM bicycles b INNER JOIN bicycle_supplier bs ON b.id = bs.bicycle_id GROUP BY bs.supplier_id) s_bicycles ON s.id = s_bicycles.supplier_id;");

        $this->render('suppliers/index.php', [
            'suppliers' => $result,
        ]);
    }
}