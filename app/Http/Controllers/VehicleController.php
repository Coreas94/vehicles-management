<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleOwnershipHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::with('user')->get();
        return response()->json($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id'
        ]);

        //Verifico que no exista el vehiculo basado en la patente
        $existingVehicle = Vehicle::where('license_plate', $request->license_plate)->first();

        if ($existingVehicle) {
            return response()->json(['error' => 'Ya existe un vehiculo con esta patente'], 400);
        }


        $vehicle = Vehicle::create($request->all());

        VehicleOwnershipHistory::create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $vehicle->user_id,
        ]);

        return response()->json(['success' => 'Vehiculo agregado correctamente'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return response()->json($vehicle->load('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        try {
            $request->validate([
                'brand' => 'string|max:255',
                'model' => 'string|max:255',
                'license_plate' => 'string|max:255|unique:vehicles,license_plate,' . $vehicle->id,
                'year' => 'integer|min:1900|max:' . date('Y'),
                'price' => 'required|numeric',
                'owner_id' => 'exists:users,id'
            ]);
    
            $previousOwnerId = $vehicle->user_id;
            $vehicle->brand = $request->input('brand');
            $vehicle->model = $request->input('model');
            $vehicle->license_plate = $request->input('license_plate');
            $vehicle->year = $request->input('year');
            $vehicle->price = $request->input('price');
            $vehicle->user_id = $request->input('owner_id');
    
            $vehicle->save();
    
            if ($previousOwnerId !== $vehicle->user_id) {
                VehicleOwnershipHistory::create([
                    'vehicle_id' => $vehicle->id,
                    'user_id' => $vehicle->user_id,
                ]);
            }
            
            return response()->json(['success' => 'Se actualizó correctamente el vehiculo'], 200);

        } catch (\Exception $e) {
            Log::error('Error actualizando el vehiculo: ' . $e->getMessage());
            return response()->json(['error' => 'Error actualizando el vehiculo'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        
        return response()->json(['success' => 'Se eliminó correctamente el vehiculo'], 200);
    }
}
