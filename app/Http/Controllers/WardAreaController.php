<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\WardArea;

class WardAreaController extends Controller
{
    //Add WardArea
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'wardAreaName' => 'required|unique:wardArea',
            'wardId' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $WardArea = WardArea::create(array_merge(
        //     $Validator->validated()
        // ));
        
           $WardArea = new WardArea();
        $WardArea->wardAreaName = $request->wardAreaName;
        $WardArea->wardId = $request->wardId;
        $WardArea->created_by = $request->userId;
        $WardArea->save();
        
        if ($WardArea) {
            return response()->json([
                'code' => 200,
                'data' => $WardArea,
                'message' => 'WardArea Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'WardArea Not Added',
            ]);
        }
    }

    // View All WardArea
    public function index()
    {
        $WardArea = WardArea::select('wardArea.id as wardAreaId', 'wardArea.wardAreaName', 'wardArea.wardId', 'ward.wardName')
            ->leftjoin('ward', 'wardArea.wardId', "=", 'ward.id')
            ->get();
        if (count($WardArea)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $WardArea,
                'message' => 'WardArea Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'WardArea Not Found',
            ]);
        }
    }

    //View WardArea By Id
    public function show($wardAreaId)
    {
        $WardArea = WardArea::select('wardArea.id as wardAreaId', 'wardArea.wardAreaName', 'wardArea.wardId', 'ward.wardName','wardArea.created_by','wardArea.updated_by')
            ->leftjoin('ward', 'wardArea.wardId', "=", 'ward.id')
            ->where('wardArea.id', $wardAreaId)->get();

        if (count($WardArea)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $WardArea[0],
                'message' => 'WardArea Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'WardArea Not Found',
            ]);
        }
    }

    //View WardArea By Ward Id
    public function getwardAreaByWardId($wardId)
    {
        $WardArea = WardArea::select('wardArea.id as wardAreaId', 'wardArea.wardAreaName', 'wardArea.wardId', 'ward.wardName','wardArea.created_by','wardArea.updated_by')
            ->leftjoin('ward', 'wardArea.wardId', "=", 'ward.id')
            ->where('wardArea.wardId', $wardId)->get();

        if (count($WardArea)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $WardArea,
                'message' => 'WardArea Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'WardArea Not Found',
            ]);
        }
    }

    //Update WardArea
    public function update(Request $request, $wardAreaId)
    {
        $request->validate([
            'wardAreaName' => 'required',
            'wardId' => 'required',
            'userId' => 'required',
        ]);

        $WardArea = WardArea::find($wardAreaId);
        if ($WardArea) {
            $WardArea->wardAreaName = $request->wardAreaName;
            $WardArea->wardId = $request->wardId;
            $WardArea->updated_by = $request->userId;
            $WardArea->update();

            return response()->json([
                'code' => 200,
                'data' => $WardArea,
                'message' => 'WardArea Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'WardArea Not Found',
            ]);
        }
    }

    //Delete WardArea
    public function destroy($wardAreaId)
    {
        $WardArea = WardArea::find($wardAreaId);

        if ($WardArea) {
            $WardArea->delete();
            return response()->json([
                'code' => 200,
                'message' => 'WardArea deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'WardArea Not Found',
            ]);
        }
    }
}
