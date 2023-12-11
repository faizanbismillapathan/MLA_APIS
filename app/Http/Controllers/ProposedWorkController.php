<?php

namespace App\Http\Controllers;

use App\Models\ProposedWork;
use Illuminate\Http\Request;
use Validator;
use DB;

class ProposedWorkController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'goanID' => 'required',
            'workName' => '',
            'price' => '',
            'reference' => '',
            'priority' => '',
            'created_by' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $data = ProposedWork::create(array_merge($Validator->validated(), ['isActive' => '1']));
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

    public function getProposedWorkByGaonId($gaonId)
    {
        $data = DB::table('proposed_work as PW')
            ->select('PW.proposed_Work_ID', 'PW.goanID', 'G.gaonName', 'PW.workName', 'PW.price', 'PW.reference', 'PW.priority','PW.created_by','PW.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'PW.GoanID')
            ->where('PW.goanID', $gaonId)
            ->where('PW.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'proposed_Work_ID' => $item->proposed_Work_ID,
                'goanID' => $item->goanID,
                'gaonName' => $item->gaonName,
                'workName' => $item->workName,
                'price' => $item->price,
                'reference' => $item->reference,
                'priority' => $item->priority,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $results[] = $res;
        }
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $results,
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
        // $data = ProposedWork::find($id);r
        $data = ProposedWork::where('proposed_Work_ID',$id)->first();
        if ($data) {
            $data->goanID = $req->goanID;
            $data->workName = $req->workName;
            $data->price = $req->price;
            $data->reference = $req->reference;
            $data->priority = $req->priority;
            $data->created_by = $req->created_by;
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

    public function destroy($id)
    {
        $data = ProposedWork::find($id);
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
