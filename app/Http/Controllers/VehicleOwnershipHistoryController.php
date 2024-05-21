<?php

namespace App\Http\Controllers;

use App\Models\VehicleOwnershipHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleOwnershipHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $histories = VehicleOwnershipHistory::with(['vehicle' => function ($query) {
            $query->withTrashed();
        }, 'user' => function ($query) {
            $query->withTrashed();
        }])->get();

        return response()->json($histories);
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
            'vehicle_id' => 'required|exists:vehicles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $history = VehicleOwnershipHistory::create($request->all());
        return response()->json($history, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleOwnershipHistory $histories)
    {
        return response()->json($histories);
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
    public function update(Request $request, VehicleOwnershipHistory $histories)
    {
        $request->validate([
            'vehicle_id' => 'exists:vehicles,id',
            'user_id' => 'exists:users,id',
        ]);

        $histories->update($request->all());
        return response()->json($histories);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleOwnershipHistory $histories)
    {
        $histories->delete();
        return response()->json(null, 204);
    }
}
