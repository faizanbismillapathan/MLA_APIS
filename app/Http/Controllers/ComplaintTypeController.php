<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use Illuminate\Http\Request;
use Validator;

class ComplaintTypeController extends Controller
{
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'complaintTypeName' => 'required | unique:complaint_types',
            'catagoryId' => 'required',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $complaintType = ComplaintType::create(array_merge($Validator->validated(), ['isActive' => '1']));
        if ($complaintType) {
            return response()->json([
                'code' => 200,
                'data' => $complaintType,
                'message' => 'Complaint Type Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Complaint Type Not Added',
            ]);
        }
    }

    public function viewAll()
    {
        $complaintType = ComplaintType::all();
        if ($complaintType) {
            return response()->json([
                'code' => 200,
                'data' => $complaintType,
                'message' => 'Complaint Type Found Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Type Not Found',
            ]);
        }
    }

    public function viewById($id)
    {
        $complaintType = ComplaintType::find($id);
        if ($complaintType) {
            return response()->json([
                'code' => 200,
                'data' => $complaintType,
                'message' => 'Complaint Type Found',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Type Not Found',
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'complaintCategoryName' => 'required',
            'updated_by' => 'required',
        ]);
        $complaintType = ComplaintType::find($id);
        if ($complaintType) {
            $complaintType->complaintTypeName = $request->complaintTypeName;
            $complaintType->catagoryId = $request->catagoryId;
            $complaintType->updated_by = $request->updated_by;
            $complaintType->update();
            return response()->json([
                'code' => 200,
                'data' => $complaintType,
                'message' => 'Complaint type Updated Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => 'Complaint Type Not Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $complaintType = ComplaintType::find($id);
        if ($complaintType) {
            $complaintType->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Complaint Type Delete Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Complaint Type Not Found',
            ]);
        }
    }

    public function complaintByCataory($catagoryId)
    {
        $complaintType = ComplaintType::where('catagoryId', $catagoryId)->get();
        if ($complaintType) {
            return response()->json([
                'code' => 200,
                'data' => $complaintType,
                'message' => 'Complaint Type Fetched Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Type Not Found',
            ]);
        }
    }
}
