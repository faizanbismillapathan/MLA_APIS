<?php

namespace App\Http\Controllers;

use App\Models\Sarpanch;
use Illuminate\Http\Request;
use Validator;
use DB;

class SarpanchController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'GoanID' => 'required',
            'Degisnation' => '',
            'Year' => '',
            'Name_ID' => 'required',
            'Remark' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $sarpanch = Sarpanch::create(array_merge($Validator->validated(), ['isActive' => '1']));
        if ($sarpanch) {
            return response()->json([
                'code' => 200,
                'data' => $sarpanch,
                'message' => 'Sarpanch Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Sarpanch Not Added',
            ]);
        }
    }

    public function getSarpanchByGaonId($gaonId,$type)
    {
        $data = DB::table('sarpanch_etc as S')
            ->select('S.Sarpanch_etc_ID', 'S.type', 'S.GoanID', 'G.gaonName', 'S.Degisnation', 'S.Year', 'S.Name_ID', 'C.fname', 'C.lname','C.number', 'S.Remark','S.created_by','S.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'S.GoanID')
            ->leftJoin('citizens as C', 'S.Name_ID', '=', 'C.id')
            ->where('S.GoanID', $gaonId)
            ->where('S.type', $type)
           // ->where('S.Degisnation', $degisnation)
            ->where('S.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'Sarpanch_etc_ID' => $item->Sarpanch_etc_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Degisnation' => $item->Degisnation,
                'Year' => $item->Year,
                'Name_ID' => $item->Name_ID,
                'fname' => $item->fname . ' ' . $item->lname,
                'number' => $item->number,
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
        // $data = Sarpanch::find($id);
        $data = Sarpanch::where('Sarpanch_etc_ID',$id)->first();
        if ($data) {
            $data->GoanID = $req->GoanID;
            $data->Degisnation = $req->Degisnation;
            $data->Year = $req->Year;
            $data->Name_ID = $req->Name_ID;
            $data->Remark = $req->Remark;
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
    // Sarpanch_etc_ID

    public function destroy($id)
    {
        $data = Sarpanch::find($id);
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
