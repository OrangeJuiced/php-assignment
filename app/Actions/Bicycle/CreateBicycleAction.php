<?php

namespace App\Actions\Bicycle;

use App\Models\Bicycle;
use App\Models\BicycleSupplier;

class CreateBicycleAction
{
    /**
     * Handle creating a bicycle.
     *
     * @param array $data
     * @return array|object
     */
    public function execute(array $data): array|object
    {
        $bicycle = new Bicycle();
        $bicycleSupplier = new BicycleSupplier();

        $bicycle = $bicycle->create([
            'model' => $data['model'],
            'price' => $data['price'],
            'description' => $data['description'],
        ]);

        foreach ($data['suppliers'] as $supplierID) {
            $bicycleSupplier->create([
                'bicycle_id' => $bicycle->id,
                'supplier_id' => $supplierID,
            ]);
        }

        return $bicycle;
    }
}