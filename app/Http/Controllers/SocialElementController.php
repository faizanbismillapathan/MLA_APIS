<?php

namespace App\Http\Controllers;

use App\Models\SocialElement;
use Illuminate\Http\Request;
use Validator;
use DB;

class SocialElementController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'goanID' => 'required',
            'componentID' => '',
            'nameID' => 'required',
            'remark' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $data = SocialElement::create(array_merge($Validator->validated(), ['isActive' => '1']));
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

    public function getsocialElementbyGaon($gaonId,$type)
    {
        $data = DB::table('social_element as SE')
            ->select('SE.social_element_ID', 'SE.type', 'SE.goanID', 'G.gaonName', 'SE.componentID', 'SEM.social_element_Name', 'SE.nameID', 'C.fname', 'C.lname', 'C.number', 'SE.remark','SE.created_by','SE.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'SE.GoanID')
            ->leftJoin('citizens as C', 'SE.nameID', '=', 'C.id')
            ->leftJoin('social_element_master as SEM', 'SEM.social_element_Master_ID', '=', 'SE.componentID')
            ->where('SE.goanID', $gaonId)
            ->where('SE.type', $type)
            ->where('SE.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'social_element_ID' => $item->social_element_ID,
                'goanID' => $item->goanID,
                'gaonName' => $item->gaonName,
                'componentID' => $item->componentID,
                'social_element_Name' => $item->social_element_Name,
                'nameID' => $item->nameID,
                'fname' => $item->fname . ' ' . $item->lname,
                'number' => $item->number,
                'remark' => $item->remark,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $result[] = $res;
        }
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
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
        $data = SocialElement::find($id);
        if ($data) {
            $data->goanID = $req->goanID;
            $data->componentID = $req->componentID;
            $data->nameID = $req->nameID;
            $data->remark = $req->remark;
            $data->created_by = $req->created_by;
            $data->updated_by = $req->updated_by;
            $data->type = $req->type;
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

    public function destroy($id)
    {
        $data = SocialElement::find($id);
        if ($data) {
            $data->isActive = 0;
            $data->update();
            return response()->json([
                'code' => 200,
                'message' => 'Data Deleted',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Data not found',
            ]);
        }
    }
}
