<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehical;

class VehicalController extends Controller
{
    //Add Vehical
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required|string|unique:vehical',
            'fuelType' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $Vehical = Vehical::create(array_merge(
        //     $Validator->validated()
        // ));
        
         $Vehical = new Vehical();
        $Vehical->name = $request->name;
        $Vehical->number = $request->number;
        $Vehical->fuelType = $request->fuelType;
        $Vehical->created_by = $request->userId;
        $Vehical->save();
        
        if ($Vehical) {
            return response()->json([
                'code' => 200,
                'data' => $Vehical,
                'message' => 'Vehical Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Vehical Not Added',
            ]);
        }
    }

    // View All Vehical
    public function index()
    {
        $Vehical = Vehical::select('vehical.id as vehicalId', 'vehical.name', 'vehical.number', 'vehical.fuelType','vehical.created_by')
            ->get();
        if (count($Vehical) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Vehical,
                'message' => 'Vehical Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehical Not Found',
            ]);
        }
    }

    //View Vehical By Id
    public function show($vehicalId)
    {
        $Vehical = Vehical::select('vehical.id as vehicalId', 'vehical.name', 'vehical.number', 'vehical.fuelType', 'vehical.created_by')
            ->where('vehical.id', $vehicalId)->get();

        if (count($Vehical) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Vehical[0],
                'message' => 'Vehical Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehical Not Found',
            ]);
        }
    }

    //Update Vehical
    public function update(Request $request, $vehicalId)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'fuelType' => 'required',
            'userId' => 'required',
        ]);

        $Vehical = Vehical::find($vehicalId);
        if ($Vehical) {
            $Vehical->name = $request->name;
            $Vehical->number = $request->number;
            $Vehical->fuelType = $request->fuelType;
            $Vehical->updated_by = $request->userId;
            $Vehical->update();

            return response()->json([
                'code' => 200,
                'data' => $Vehical,
                'message' => 'Vehical Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehical Not Found',
            ]);
        }
    }

    //Delete Vehical
    public function destroy($vehicalId)
    {
        $Vehical = Vehical::find($vehicalId);

        if ($Vehical) {
            $Vehical->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Vehical deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Vehical Not Found',
            ]);
        }
    }
}
