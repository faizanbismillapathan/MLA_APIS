<?php

namespace App\Http\Controllers;

use App\Models\SocialElementMaster;
use Illuminate\Http\Request;
use Validator;
use DB;

class SocialElementMasterController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'social_element_Name' => 'required | unique:social_element_master',
            'created_by' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->error()->tojson(), 400);
        }
        $data = SocialElementMaster::create(array_merge($Validator->validated(), ['isActive' => '1']));
        if ($data) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Data Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Data Not Added',
            ]);
        }
    }
    
    
    public function getAllSocialElements()
    {
        $data = DB::table('social_element_master as SEM')
            ->select('SEM.social_element_Master_ID', 'SEM.social_element_Name')
            ->where('SEM.isActive', 1)
            ->get();
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Data Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Data Not Added',
            ]);
        }
    }
    
    public function edit(Request $req, $id)
    {
        // $data = SocialElementMaster::find($id);
        $data = SocialElementMaster::where('social_element_Master_ID',$id)->first();
        if ($data) {
            $data->social_element_Name = $req->social_element_Name;
            $data->update();
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Data Updated',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Found',
            ]);
        }
    }
}
