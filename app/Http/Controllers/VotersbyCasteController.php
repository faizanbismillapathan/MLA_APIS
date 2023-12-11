<?php

namespace App\Http\Controllers;

use App\Models\VotersbyCaste;
use Illuminate\Http\Request;
use Validator;
use DB;

class VotersbyCasteController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'GoanID' => 'required',
            'Cast_OR_Community_Name' => '',
            'Number' => '',
            'Remark' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }

        $data = VotersbyCaste::create(array_merge($Validator->validated(), ['isActive' => '1']));

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

    public function getCastVotersByGaonId($gaonId,$type)
    {
        $data = DB::table('voters_by_caste as VC')
            ->select('VC.Voters_by_Caste_ID', 'VC.type', 'VC.GoanID', 'G.gaonName', 'VC.Cast_OR_Community_Name', 'VC.Number', 'VC.Remark','VC.created_by','VC.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'VC.GoanID')
            ->where('VC.GoanID', $gaonId)
            ->where('VC.type', $type)
            ->where('VC.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'Voters_by_Caste_ID' => $item->Voters_by_Caste_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Cast_OR_Community_Name' => $item->Cast_OR_Community_Name,
                'Number' => $item->Number,
                'Remark' => $item->Remark,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $result[] = $res;
        }
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'message' => 'Data Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => 'Data Not Fetched',
            ]);
        }
    }

    public function edit(Request $req, $id)
    {
        // $data = VotersbyCaste::find($id);
        $data = VotersbyCaste::where('Voters_by_Caste_ID',$id)->first();
        if ($data) {
            $data->GoanID = $req->GoanID;
            $data->Cast_OR_Community_Name = $req->Cast_OR_Community_Name;
            $data->Number = $req->Number;
            $data->Remark = $req->Remark;
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
    // Voters_by_Caste_ID
    public function destroy($id)
    {
        $data = VotersbyCaste::find($id);
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
