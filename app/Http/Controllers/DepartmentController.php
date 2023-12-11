<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Validator;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'departmentName' => 'required | unique:departments',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $department = Department::create(array_merge($Validator->validated()));
        if ($department) {
            return response()->json([
                'code' => 200,
                'data' => $department,
                'messsage' => 'Department Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Department Not Added',
            ]);
        }
    }

    public function viewAll()
    {
        $department = Department::all();
        if ($department) {
            return response()->json([
                'code' => 200,
                'data' => $department,
                'message' => 'Department Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Department Not Found',
            ]);
        }
    }

    public function viewById($id)
    {
        $department = Department::find($id);
        if ($department) {
            return response()->json([
                'code' => 200,
                'data' => $department,
                'message' => 'Department Found',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Department Not Found',
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $department = Department::find($id);
        if ($department) {
            $department->departmentName = $request->departmentName;
            $department->complaintTypeId = $request->complaintTypeId;
            $department->updated_by = $request->updated_by;
            $department->update();
            return response()->json([
                'code' => 200,
                'data' => $department,
                'message' => 'Department Updated Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Department Not Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        if ($department) {
            $department->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Department Deleted',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Department Not Found',
            ]);
        }
    }

    public function departmentByComplaintTypeId($complaintTypeId)
    {
        $department = Department::where('complaintTypeId', $complaintTypeId)->get();
        if ($department) {

            return response()->json([
                'code' => 200,
                'data' => $department,
                'message' => 'Department Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Department Not Found',
            ]);
        }
    }
}
