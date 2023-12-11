<?php

namespace App\Http\Controllers;

use App\Models\PartyWorkers;
use Illuminate\Http\Request;
use Validator;
use DB;

class PartyWorkersController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'GoanID' => 'required',
            'Party' => '',
            'Name_ID' => 'required',
            'Party_Responsibility' => '',
            'Status' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $data = PartyWorkers::create(array_merge($Validator->validated(), ['isActive' => '1']));
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

    public function getPartyWorkerByGaonId($gaonId,$type)
    {
        $data = DB::table('party_workers as PW')
            ->select('PW.Party_Workers_ID', 'PW.type', 'PW.GoanID', 'G.gaonName', 'PW.Party', 'PW.Name_ID', 'C.fname', 'C.lname', 'C.number', 'C.occupation', 'PW.Party_Responsibility', 'PW.Status','PW.created_by','PW.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'PW.GoanID')
            ->leftJoin('citizens as C', 'PW.Name_ID', '=', 'C.id')
            ->where('PW.GoanID', $gaonId)
            ->where('PW.type', $type)
            ->where('PW.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'Party_Workers_ID' => $item->Party_Workers_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Party' => $item->Party,
                'Name_ID' => $item->Name_ID,
                'fname' => $item->fname . ' ' . $item->lname,
                'number' => $item->number,
                'occupation' => $item->occupation,
                'Party_Responsibility' => $item->Party_Responsibility,
                'Status' => $item->Status,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
                'type' => $item->type,
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
        $data = PartyWorkers::where('Party_Workers_ID',$id)->first();
        // $data = PartyWorkers::find($id);
        if ($data) {
            $data->GoanID = $req->GoanID;
            $data->Party = $req->Party;
            $data->Name_ID = $req->Name_ID;
            $data->Party_Responsibility = $req->Party_Responsibility;
            $data->Status = $req->Status;
            $data->updated_by = $req->updated_by;
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
    // Party_Workers_ID

    public function destroy($id)
    {
        $data = PartyWorkers::find($id);
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
