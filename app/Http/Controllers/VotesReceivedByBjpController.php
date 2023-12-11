<?php

namespace App\Http\Controllers;

use App\Models\votes_received_by_bjp;
use Illuminate\Http\Request;
use Validator;
use DB;

class VotesReceivedByBjpController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'GoanID' => 'required',
            'Year' => '',
            'Total_votes' => '',
            'Received_votes' => '',
            'Percentage' => '',
            'Remark' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }

        $votes = votes_received_by_bjp::create(array_merge($Validator->validated(), ['isActive' => '1']));

        if ($votes) {
            return response()->json([
                'code' => 200,
                'data' => $votes,
                'message' => 'Data Added Successsfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Data Not Added',
            ]);
        }
    }

    public function getBJPVoterByGaonId($gaonId,$type)
    {
        $data = DB::table('votes_received_by_bjp as bjp')
            ->select('bjp.Votes_received_by_BJP_ID', 'bjp.type', 'bjp.GoanID', 'G.gaonName', 'bjp.Year', 'bjp.Total_votes', 'bjp.Received_votes', 'bjp.Percentage', 'bjp.Remark','bjp.created_by','bjp.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'bjp.GoanID')
            ->where('bjp.GoanID', $gaonId)
            ->where('bjp.type', $type)
            ->where('bjp.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'Votes_received_by_BJP_ID' => $item->Votes_received_by_BJP_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Year' => $item->Year,
                'Total_votes' => $item->Total_votes,
                'Received_votes' => $item->Received_votes,
                'Percentage' => $item->Percentage,
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
        // $data = votes_received_by_bjp::find($id);
        $data = votes_received_by_bjp::where('Votes_received_by_BJP_ID',$id)->first();
        if ($data) {
            $data->GoanID = $req->GoanID;
            $data->Year = $req->Year;
            $data->Total_votes = $req->Total_votes;
            $data->Received_votes = $req->Received_votes;
            $data->Percentage = $req->Percentage;
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
    // Votes_received_by_BJP_ID

    public function destroy($id)
    {
        $data = votes_received_by_bjp::find($id);
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
