<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Assembly;

class AssemblyController extends Controller
{
    //Add Assembly
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'assemblyName' => 'required|unique:assembly',
            'userId' => 'required',
            // 'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $Assembly = Assembly::create(array_merge(
        //     $Validator->validated()
        // ));
        $Assembly = new Assembly();
        $Assembly->assemblyName = $request->assemblyName;
        $Assembly->created_by = $request->userId;
        $Assembly->save();
        

        if ($Assembly) {
            return response()->json([
                'code' => 200,
                'data' => $Assembly,
                'message' => 'Assembly Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Assembly Not Added',
            ]);
        }
    }

    // View All Assembly
    public function index()
    {
        $Assembly = Assembly::select('assembly.id as assemblyId', 'assembly.assemblyName','assembly.created_by','assembly.updated_by')->get();
        if (count($Assembly)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Assembly,
                'message' => 'Assembly Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Assembly Not Found',
            ]);
        }
    }

    //View Ward By Id
    public function show($assemblyId)
    {
        $Assembly = Assembly::select('assembly.id as assemblyId', 'assembly.assemblyName','assembly.created_by','assembly.updated_by')->where('assembly.id', $assemblyId)->get();

        if (count($Assembly)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Assembly[0],
                'message' => 'Assembly Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Assembly Not Found',
            ]);
        }
    }

    //Update Assembly
    public function update(Request $request, $assemblyId)
    {
        $request->validate([
            'assemblyName' => 'required',
            'userId' => 'required',
        ]);

        $Assembly = Assembly::find($assemblyId);
        if ($Assembly) {
            $Assembly->assemblyName = $request->assemblyName;
            $Assembly->updated_by = $request->userId;
            $Assembly->update();

            return response()->json([
                'code' => 200,
                'data' => $Assembly,
                'message' => 'Assembly Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Assembly Not Found',
            ]);
        }
    }

    //Delete Assembly
    public function destroy($assemblyId)
    {
        $Assembly = Assembly::find($assemblyId);

        if ($Assembly) {
            $Assembly->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Assembly deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Assembly Not Found',
            ]);
        }
    }
}
