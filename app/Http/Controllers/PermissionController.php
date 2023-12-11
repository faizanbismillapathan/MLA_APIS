<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermissionController extends Controller
{
     //Add Permission
     public function store(Request $request)
     {
         $Validator = Validator::make($request->all(), [
             'permission' => 'required',
             'created_by' => 'required',
         ]);
         if ($Validator->fails()) {
             return response()->json($Validator->errors()->tojson(), 400);
         }
         $Permission = Permission::create(array_merge(
             $Validator->validated(),
         ));

         if ($Permission) {
             return response()->json([
                 'code' => 200,
                 'data' => $Permission,
                 'message' => 'Permission Added Sucecssfully',
             ]);
         } else {
             return response()->json([
                 'code' => 400,
                 'data' => [],
                 'message' => 'Permission Not Added',
             ]);
         }
     }

     // View All Permission
     public function index()
     {
         $Permission = Permission::select('permissions.id as permissionId', 'permissions.permission','permissions.created_by','permissions.updated_by')->get();
         if (count($Permission)!=0) {
             return response()->json([
                 'code' => 200,
                 'data' => $Permission,
                 'message' => 'Permission Fetched Sucecssfully',
             ]);
         } else {
             return response()->json([
                 'code' => 404,
                 'data' => [],
                 'message' => 'Permission Not Found',
             ]);
         }
     }

     //View Permission By Id
     public function show($permissionId)
     {
         $Permission = Permission::select('permissions.id as permissionId', 'permissions.permission','permissions.created_by','permissions.updated_by')->where('permissions.id', $permissionId)->get();

         if (count($Permission)!=0) {
             return response()->json([
                 'code' => 200,
                 'data' => $Permission[0],
                 'message' => 'Permission Fetched Sucecssfully',
             ]);
         } else {
             return response()->json([
                 'code' => 404,
                 'data' => [],
                 'message' => 'Permission Not Found',
             ]);
         }
     }

     //Update Permission
     public function update(Request $request, $permissionId)
     {
         $request->validate([
             'permission' => 'required',
             'updated_by' => 'required',
         ]);

         $Permission = Permission::find($permissionId);
         if ($Permission) {
             $Permission->permission = $request->permission;
             $Permission->updated_by = $request->updated_by;
             $Permission->update();

             return response()->json([
                 'code' => 200,
                 'data' => $Permission,
                 'message' => 'Permission Updated Successfully',
             ], 200);
         } else {
             return response()->json([
                 'code' => 404,
                 'data' => [],
                 'message' => 'Permission Not Found',
             ]);
         }
     }

     //Delete Permission
     public function destroy($permissionId)
     {
         $Permission = Permission::find($permissionId);

         if ($Permission) {
             $Permission->delete();
             return response()->json([
                 'code' => 200,
                 'message' => 'Permission deleted Successfully',
             ], 200);
         } else {
             return response()->json([
                 'code' => 404,
                 'data' => [],
                 'message' => 'Permission Not Found',
             ]);
         }
     }
}
