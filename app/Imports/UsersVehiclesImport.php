<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleOwnershipHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;

class UsersVehiclesImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            
            $rowData = $row->toArray();

            if (empty(array_filter($rowData))) {
                continue; // Por si viene una fila vacia la omito
            }

            // Salta la fila de encabezado
            if ($rowData[0] == 'Nombre') {
                continue;
            }

            // Validar los datos antes de insertarlos
            if (count($rowData) < 8) {
                Log::warning('Fila incompleta: ' . implode(', ', $rowData));
                continue; // Omito fila incompleta
            }

            $user = User::updateOrCreate(
                ['email' => $rowData[2]],
                ['name' => $rowData[0], 'surname' => $rowData[1]]
            );

            $vehicle = Vehicle::updateOrCreate(
                ['license_plate' => $rowData[5]],
                [
                    'brand' => $rowData[3],
                    'model' => $rowData[4],
                    'year' => $rowData[6],
                    'price' => $rowData[7],
                    'user_id' => $user->id
                ]
            );

            VehicleOwnershipHistory::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
