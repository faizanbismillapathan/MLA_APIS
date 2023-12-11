<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ward;

class WardController extends Controller
{
    //Add Ward
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'wardName' => 'required|unique:ward',
            'assemblyId' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $Ward = Ward::create(array_merge(
        //     $Validator->validated()
        // ));
        
         $Ward = new Ward();
        $Ward->wardName = $request->wardName;
        $Ward->assemblyId = $request->assemblyId;
        $Ward->created_by = $request->userId;
        $Ward->save();
        
        if ($Ward) {
            return response()->json([
                'code' => 200,
                'data' => $Ward,
                'message' => 'Ward Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Ward Not Added',
            ]);
        }
    }

    // View All Ward
    public function index()
    {
        $Ward = Ward::select('ward.id as wardId', 'ward.wardName', 'ward.assemblyId', 'assembly.assemblyName')
            ->leftjoin('assembly', 'ward.assemblyId', "=", 'assembly.id')
            ->get();
        if (count($Ward)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Ward,
                'message' => 'Ward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Ward Not Found',
            ]);
        }
    }

    //View Ward By Id
    public function show($wardId)
    {
        $Ward = Ward::select('ward.id as wardId', 'ward.wardName', 'ward.assemblyId', 'assembly.assemblyName','ward.created_by','ward.updated_by')
            ->leftjoin('assembly', 'ward.assemblyId', "=", 'assembly.id')
            ->where('ward.id', $wardId)->get();

        if (count($Ward)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Ward[0],
                'message' => 'Ward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Ward Not Found',
            ]);
        }
    }

    //View Ward By Assembly Id
    public function getWardByAssemblyId($assemblyId)
    {
        $Ward = Ward::select('ward.id as wardId', 'ward.wardName', 'ward.assemblyId', 'assembly.assemblyName','ward.created_by','ward.updated_by')
            ->leftjoin('assembly', 'ward.assemblyId', "=", 'assembly.id')
            ->where('ward.assemblyId', $assemblyId)->get();

        if (count($Ward)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Ward,
                'message' => 'Ward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Ward Not Found',
            ]);
        }
    }

    //Update Ward
    public function update(Request $request, $wardId)
    {
        $request->validate([
            'wardName' => 'required',
            'assemblyId' => 'required',
            'userId' => 'required',
        ]);

        $Ward = Ward::find($wardId);
        if ($Ward) {
            $Ward->wardName = $request->wardName;
            $Ward->assemblyId = $request->assemblyId;
            $Ward->updated_by = $request->userId;
            $Ward->update();

            return response()->json([
                'code' => 200,
                'data' => $Ward,
                'message' => 'Ward Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Ward Not Found',
            ]);
        }
    }

    //Delete Ward
    public function destroy($wardId)
    {
        $Ward = Ward::find($wardId);

        if ($Ward) {
            $Ward->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Ward deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Ward Not Found',
            ]);
        }
    }
}
