<?php

namespace App\Actions\Bicycle;

use App\Models\Bicycle;
use App\Models\BicycleSupplier;

class DeleteBicycleAction
{
    /**
     * Handle deleting a bicycle.
     *
     * @param int $id
     * @return void
     */
    public function execute(int $id): void
    {
        $bicycle = new Bicycle();
        $bicycleSupplier = new BicycleSupplier();

        $bicycle->find($id)->delete();

        $bicycleSupplier->deleteWhere('bicycle_id', '=', $id);
    }
}