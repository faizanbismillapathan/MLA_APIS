<?php

namespace App\Http\Controllers;

use App\Models\KhatavaniDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class KhatavaniDetailsController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            // 'Khatavani_Details_ID' => 'required',
            'GoanID' => 'required',
            'Total_number_of_voters' => '',
            'No_of_booths' => '',
            'Hindu' => '',
            'Muslim' => '',
            'Baudhaa' => '',
            'Other' => '',
            'created_by' => '',
            'type' => '',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $khatavni = KhatavaniDetails::create(array_merge($Validator->validated(), ['isActive' => '1']));
        if ($khatavni) {
            return response()->json([
                'code' => 200,
                'data' => $khatavni,
                'message' => 'Khatavni Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Khatavni Not Added',
            ]);
        }
    }

    public function getKhatavniByGaonId($gaonId,$type)
    {
        $khatavaniDetails = DB::table('khatavani_details as KD')
            ->select('KD.Khatavani_Details_ID', 'KD.type', 'KD.GoanID', 'G.gaonName', 'KD.Total_number_of_voters', 'KD.No_of_booths', 'KD.Hindu', 'KD.Muslim', 'KD.Baudhaa', 'KD.Other','KD.created_by','KD.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'KD.GoanID')
            ->where('KD.GoanID', $gaonId)
            ->where('KD.type', $type)
            ->where('KD.isActive', 1)
            ->get();
        foreach ($khatavaniDetails as $item) {
            $res = [
                'Khatavani_Details_ID' => $item->Khatavani_Details_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Total_number_of_voters' => $item->Total_number_of_voters,
                'No_of_booths' => $item->No_of_booths,
                'Hindu' => $item->Hindu,
                'Muslim' => $item->Muslim,
                'Baudhaa' => $item->Baudhaa,
                'Other' => $item->Other,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $result[] = $res;
        }
        if (count($khatavaniDetails) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'message' => 'Data Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Found',
            ]);
        }
    }

    public function edit(Request $req, $khataniId)
    {
        $data = KhatavaniDetails::where('Khatavani_Details_ID', $khataniId)->first();
        // print_r($data);
        // exit;
        // $data = KhatavaniDetails::find($khataniId);
        if ($data) {
            $data->GoanID = $req->GoanID;
            $data->Total_number_of_voters = $req->Total_number_of_voters;
            $data->No_of_booths = $req->No_of_booths;
            $data->Hindu = $req->Hindu;
            $data->Muslim = $req->Muslim;
            $data->Baudhaa = $req->Baudhaa;
            $data->Other = $req->Other;
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
    // Khatavani_Details_ID
    public function destroy($id)
    {
        $data = KhatavaniDetails::find($id);
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
