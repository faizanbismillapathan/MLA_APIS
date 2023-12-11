<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\UserPermission;

class UserPermissionController extends Controller
{
    //Add UserPermission
    public function store(Request $request, $userId)
    {
        $Validator = Validator::make($request->all(), [
            'permissionId' => 'required',
            'userId' => '',
            'permissionBy' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }

        // if ($request->permissionId) {
        if (is_array($request->permissionId)) {
            $permissionArray = $request->permissionId;
             $savedPermissions = [];
            foreach ($permissionArray as $permissionId) {
                $userPermission = new UserPermission();
                $userPermission->permissionId = $permissionId['permissionId'];
                $userPermission->userId = $userId;
                $userPermission->created_by = $permissionId['permissionBy'];
                $userPermission->save();
                $savedPermissions[] = $userPermission;
            }
        }
        
        if($userPermission){
            return response()->json([
                'message' => 'Permission Assigned Successfully',
                'permission' => $savedPermissions,
            ], 201);
        }else{
            return response()->json([
                'message' => 'Permission Not Assigned',
                'user' => [],
                'permission' => [],
            ], 401);
        }
    }

    // View All UserPermission
    public function index()
    {
        $UserPermission = UserPermission::select('userPermission.userId', 'citizens.fname as userFname', 'citizens.mname as userMname', 'citizens.lname as username', 'citizens.number as userNumber', 'citizens.gender as userGender', 'citizens.email as userEmail', 'citizens.role as userRole', 'userPermission.created_by', 'userPermission.updated_by')
            ->leftjoin('citizens', 'userPermission.userId', '=', 'citizens.id')
            ->distinct()
            ->get();
        if (count($UserPermission) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $UserPermission,
                'message' => 'User Permission Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'User Permission Not Found',
            ]);
        }
    }

    //View Permission By Id
    public function show($userId)
    {
        $User = UserPermission::select('userPermission.userId', 'citizens.fname as userFname', 'citizens.mname as userMname', 'citizens.lname as username', 'citizens.number as userNumber', 'citizens.gender as userGender', 'citizens.email as userEmail', 'citizens.role as userRole', 'userPermission.created_by', 'userPermission.updated_by')
            ->leftjoin('citizens', 'userPermission.userId', '=', 'citizens.id')
            ->where('userPermission.userId', $userId)
            ->distinct()
            ->get();

        $UserPermission = UserPermission::select('userPermission.id as userPermissionId', 'userPermission.permissionId', 'permissions.permission', 'userPermission.userId', 'userPermission.created_by', 'userPermission.updated_by')
            ->leftjoin('permissions', 'userPermission.permissionId', '=', 'permissions.id')
            ->leftjoin('citizens', 'userPermission.userId', '=', 'citizens.id')
            ->where('userPermission.userId', $userId)->get();

        $Permissions = Permission::select('permissions.id as permissionId', 'permissions.permission', 'permissions.created_by', 'permissions.updated_by')->get();

        foreach ($Permissions as $permission) {
        $ischecked=UserPermission::where('userPermission.permissionId',$permission->permissionId)->where('userPermission.userId', $userId)->get();

            $res = [
                'permissionId' => $permission->permissionId,
                'permission' => $permission->permission,
                'ischecked' => count($ischecked)!=0 ? 'true' : 'false',
                'created_by' => $permission->created_by,
                'updated_by' => $permission->updated_by,
            ];


            $result[] = $res;
        }

        // {
        //     userid:1
        //      arrayname:[
        //          {id:1, permissionname:"",permissonid:"",ischecked:true},
        //          {id:1, permissionname:"",permissonid:"",ischecked:false},
        //          {id:1, permissionname:"",permissonid:"",}
        //       ],
        //      ceated_by:yzb;
        //   }

        if (count($UserPermission) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $User,
                'UserPermission' => $result,
                'message' => 'User Permission Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'UserPermission' => [],
                'message' => 'User Permission Not Found',
            ]);
        }
    }

    //Update UserPermission
    public function update(Request $request, $userPermissionId)
    {
        // $request->validate([
        //     'permissionId' => 'required',
        //     'userId' => 'required',
        //     'created_by' => 'required',
        // ]);
        $Validator = $request->all();
        $count = count($Validator);

        if ($Validator[0]['permissionId']) {
            for ($i = 0; $i < $count; $i++) {
                $data = [
                    'userId' => $Validator[$i]['userId'],
                    'permissionId' => $Validator[$i]['permissionId'],
                    'created_by' => $Validator[$i]['created_by'],
                ];
                $UserPermission = UserPermission::create(array_merge($data));
            }
            return response()->json([
                'code' => 200,
                'data' => $UserPermission,
                'message' => 'User Permission Updated Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'User Permission Not Found',
            ]);
        }

        // $UserPermission = UserPermission::find($userPermissionId);
        // if ($UserPermission) {
        //     $UserPermission->permissionId = $request->permissionId;
        //     $UserPermission->userId = $request->userId;
        //     $UserPermission->updated_by = $request->updated_by;
        //     $UserPermission->update();

        //     return response()->json([
        //         'code' => 200,
        //         'data' => $UserPermission,
        //         'message' => 'User Permission Updated Successfully',
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'code' => 404,
        //         'data' => [],
        //         'message' => 'User Permission Not Found',
        //     ]);
        // }
    }

    //Delete UserPermission
    public function destroy($userId)
    {
        $UserPermission = UserPermission::where('userId', $userId)->delete();

        if ($UserPermission) {
            return response()->json([
                'code' => 200,
                'message' => 'User Permission deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'User Permission Not Found',
            ]);
        }
    }
    
    // Update Permission By User Id
    public function updatePermissionByUserId(Request $request, $userId)
    {
        $ischecked = UserPermission::where('userPermission.userId', $userId)->get();
        // print_r($ischecked);
        // exit;
        if (count($ischecked) != 0) {
            $ischecked = UserPermission::where('userPermission.userId', $userId)->delete();
                $savedPermissions = [];
            if ($request->permissionId) {
                $permissionArray = $request->permissionId;
                foreach ($permissionArray as $permissionId) {
                    $userPermission = new UserPermission();
                    $userPermission->permissionId = $permissionId['permissionId'];
                    $userPermission->userId = $userId;
                    $userPermission->created_by = $permissionId['created_by'];
                    $userPermission->save();
                    $savedPermissions[] = $userPermission;
                }
            }
            if(!empty($userPermission)){    
                return response()->json([
                    'code' => 200,
                    'data' => $ischecked,
                    'message' => 'Permission Updated while permission is exist',
                ]);
            }else{
                return response()->json([
                    'code' => 400,
                    // 'data' => $savedPermissions,
                    'message' => 'Permission Not Updated while permission is exist',
                ]);
            }
        } else {
            if ($request->permissionId) {
            $savedPermissions = [];
                $permissionArray = $request->permissionId;
                foreach ($permissionArray as $permissionId) {
                    $userPermission = new UserPermission();
                    $userPermission->permissionId = $permissionId['permissionId'];
                    $userPermission->userId = $userId;
                    $userPermission->created_by = $permissionId['created_by'];
                    $userPermission->save();
                    $savedPermissions[] = $userPermission;
                }
            }
            if(!empty($userPermission)){    
                return response()->json([
                    'code' => 200,
                    'data' => $permissionArray,
                    'message' => 'Permission Updated while permission is not exist',
                ]);
            }else{
                return response()->json([
                    'code' => 400,
                    'data' => $permissionArray,
                    'message' => 'Permission Not Updated while permission is not exist',
                ]);
            }
        }
    }
}
