<?php

namespace App\Http\Controllers;

use App\Models\InfluentialPersons;
use Illuminate\Http\Request;
use Validator;
use DB;

class InfluentialPersonsController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'GoanID' => 'required',
            'Degisnation' => '',
            'Name_ID' => 'required',
            'Society' => '',
            'Status' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }

        $data = InfluentialPersons::create(array_merge($Validator->validated(), ['isActive' => '1']));

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

    public function getInfluentialPersonByGaonId($gaonId,$type)
    {
        $data = DB::table('influential_persons as IP')
            ->select('IP.Influential_Persons_ID', 'IP.type', 'IP.GoanID', 'G.gaonName', 'IP.Degisnation', 'IP.Name_ID', 'C.fname', 'C.lname', 'C.occupation', 'C.number', 'IP.Society', 'IP.Status','IP.created_by','IP.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'IP.GoanID')
            ->leftJoin('citizens as C', 'IP.Name_ID', '=', 'C.id')
            ->where('IP.GoanID', $gaonId)
            ->where('IP.type', $type)
            ->where('IP.isActive', 1)
            ->get();

        foreach ($data as $item) {
            $res = [
                'Influential_Persons_ID' => $item->Influential_Persons_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Degisnation' => $item->Degisnation,
                'Name_ID' => $item->Name_ID,
                'fname' => $item->fname . ' ' . $item->lname,
                'number' => $item->number,
                'occupation' => $item->occupation,
                'Society' => $item->Society,
                'Status' => $item->Status,
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
        $data = InfluentialPersons::where('Influential_Persons_ID', $id)->first();
        // $data = InfluentialPersons::find($id);
        if ($data) {
            $data->GoanID = $req->GoanID;
            $data->Degisnation = $req->Degisnation;
            $data->Name_ID = $req->Name_ID;
            $data->Society = $req->Society;
            $data->Status = $req->Status;
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
    // Influential_Persons_ID

    public function destroy($id)
    {
        $data = InfluentialPersons::find($id);
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
