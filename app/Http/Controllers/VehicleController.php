<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    //Add Vehicle
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required|unique:ward',
            'number' => 'required',
            'fuelType' => 'required',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $Vehicle = Vehicle::create(array_merge(
            $Validator->validated()
        ));
        if ($Vehicle) {
            return response()->json([
                'code' => 200,
                'data' => $Vehicle,
                'message' => 'Vehicle Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Vehicle Not Added',
            ]);
        }
    }

    // View All Vehicle
    public function index()
    {
        $Vehicle = Vehicle::select('vehicle.id as vehicleId', 'vehicle.name', 'vehicle.number', 'vehicle.fuelType')
            ->get();
        if (count($Vehicle) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Vehicle,
                'message' => 'Vehicle Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehicle Not Found',
            ]);
        }
    }

    //View Vehicle By Id
    public function show($vehicleId)
    {
        $Vehicle = Vehicle::select('vehicle.id as vehicleId', 'vehicle.name', 'vehicle.number', 'vehicle.fuelType')
            ->where('vehicle.id', $vehicleId)->get();

        if (count($Vehicle) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Vehicle[0],
                'message' => 'Vehicle Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehicle Not Found',
            ]);
        }
    }

    //Update Vehicle
    public function update(Request $request, $vehicleId)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'fuelType' => 'required',
            'updated_by' => 'required',
        ]);

        $Vehicle = Vehicle::find($vehicleId);
        if ($Vehicle) {
            $Vehicle->name = $request->name;
            $Vehicle->number = $request->number;
            $Vehicle->fuelType = $request->fuelType;
            $Vehicle->updated_by = $request->updated_by;
            $Vehicle->update();

            return response()->json([
                'code' => 200,
                'data' => $Vehicle,
                'message' => 'Vehicle Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehicle Not Found',
            ]);
        }
    }

    //Delete Vehicle
    public function destroy($vehicleId)
    {
        $Vehicle = Vehicle::find($vehicleId);

        if ($Vehicle) {
            $Vehicle->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Vehicle deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehicle Not Found',
            ]);
        }
    }
}
