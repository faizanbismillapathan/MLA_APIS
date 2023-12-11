<?php

namespace App\Http\Controllers;

use App\Models\OutofTownVoter;
use Illuminate\Http\Request;
use Validator;
use DB;

class OutofTownVoterController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'goanID' => 'required',
            'name_ID' => '',
            'society' => '',
            'voter_List_No' => '',
            'reference' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $data = OutofTownVoter::create(array_merge($Validator->validated(), ['isActive' => '1']));
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

    public function GetOutOfTownVotersBygaonId($gaonId,$type)
    {
        $data = DB::table('out-of-town_voter as OV')
            ->select('OV.Out_of_Town_Voter_ID', 'OV.type', 'OV.goanID', 'G.gaonName', 'OV.name_ID', 'C.fname', 'C.lname', 'C.number', 'OV.society', 'OV.voter_List_No', 'OV.reference','OV.created_by','OV.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'OV.GoanID')
            ->leftJoin('citizens as C', 'OV.Name_ID', '=', 'C.id')
            ->where('OV.goanID', $gaonId)
            ->where('OV.type', $type)
            ->where('OV.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'Out_of_Town_Voter_ID' => $item->Out_of_Town_Voter_ID,
                'goanID' => $item->goanID,
                'gaonName' => $item->gaonName,
                'name_ID' => $item->name_ID,
                'fname' => $item->fname . ' ' . $item->lname,
                'number' => $item->number,
                'society' => $item->society,
                'voter_List_No' => $item->voter_List_No,
                'reference' => $item->reference,
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
        // $data = OutofTownVoter::find($id);
        $data = OutofTownVoter::where('Out_of_Town_Voter_ID', $id)->first();
        if ($data) {
            // print_r($data);
            // exit;
            $data->goanID = $req->goanID;
            $data->name_ID = $req->name_ID;
            $data->society = $req->society;
            $data->voter_List_No = $req->voter_List_No;
            $data->reference = $req->reference;
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
        $data = OutofTownVoter::find($id);
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
