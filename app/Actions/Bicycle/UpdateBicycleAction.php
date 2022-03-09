<?php

namespace App\Actions\Bicycle;

use App\Models\Bicycle;
use App\Models\BicycleSupplier;

class UpdateBicycleAction
{
    /**
     * Handle updating a bicycle.
     *
     * @param int $id
     * @param array $data
     * @return array|object
     */
    public function execute(int $id, array $data): array|object
    {
        $bicycleModel = new Bicycle();
        $bicycleSupplierModel = new BicycleSupplier();

        $bicycle = $bicycleModel->find($id);

        $bicycle->update([
            'model' => $data['model'],
            'price' => $data['price'],
            'description' => $data['description'],
        ]);

        $bicycleSupplierModel->deleteWhere('bicycle_id', '=', $id);

        foreach ($data['suppliers'] as $supplierID) {
            $bicycleSupplierModel->create([
                'bicycle_id' => $bicycle->id,
                'supplier_id' => $supplierID,
            ]);
        }

        return $bicycle;
    }
}