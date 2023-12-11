<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Gaon;
use Illuminate\Support\Facades\DB;

class GaonController extends Controller
{
    //Add Gaon
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'gaonName' => 'required',
            'talukaPanchayatId' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $Gaon = Gaon::create(array_merge(
        //     $Validator->validated()
        // ));
        
        $Gaon = new Gaon();
        $Gaon->gaonName = $request->gaonName;
        $Gaon->talukaPanchayatId = $request->talukaPanchayatId;
        $Gaon->created_by = $request->userId;
        $Gaon->save();
        
        if ($Gaon) {
            return response()->json([
                'code' => 200,
                'data' => $Gaon,
                'message' => 'Gaon Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Gaon Not Added',
            ]);
        }
    }

    // View All Gaon
    public function index()
    {
        $Gaon = Gaon::select('gaon.id as gaonId', 'gaon.gaonName', 'gaon.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName','gaon.created_by','gaon.updated_by')
            ->leftjoin('taluka_panchayats', 'gaon.talukaPanchayatId', "=", 'taluka_panchayats.id')
            ->get();
        if (count($Gaon)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Gaon,
                'message' => 'Gaon Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Gaon Not Found',
            ]);
        }
    }

    //View Gaon By Id
    public function show($gaonId)
    {
        $Gaon = Gaon::select('gaon.id as gaonId', 'gaon.gaonName', 'gaon.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName','gaon.created_by','gaon.updated_by')
            ->leftjoin('taluka_panchayats', 'gaon.talukaPanchayatId', "=", 'taluka_panchayats.id')
            ->where('gaon.id', $gaonId)->get();

        if (count($Gaon)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Gaon[0],
                'message' => 'Gaon Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Gaon Not Found',
            ]);
        }
    }

    //View Gaon By TalukaPanchayatId Id
    public function getGaonByTalukaPanchayatId($talukaPanchayatId)
    {
        $Gaon = Gaon::select('gaon.id as gaonId', 'gaon.gaonName', 'gaon.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName','gaon.created_by','gaon.updated_by')
            ->leftjoin('taluka_panchayats', 'gaon.talukaPanchayatId', "=", 'taluka_panchayats.id')
            ->where('gaon.talukaPanchayatId', $talukaPanchayatId)->get();

        if (count($Gaon)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Gaon,
                'message' => 'Gaon Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Gaon Not Found',
            ]);
        }
    }

    //Update Gaon
    public function update(Request $request, $gaonId)
    {
        $request->validate([
            'gaonName' => 'required',
            'talukaPanchayatId' => 'required',
            'userId' => 'required',
        ]);

        $Gaon = Gaon::find($gaonId);
        if ($Gaon) {
            $Gaon->gaonName = $request->gaonName;
            $Gaon->talukaPanchayatId = $request->talukaPanchayatId;
            $Gaon->updated_by = $request->userId;
            $Gaon->update();

            return response()->json([
                'code' => 200,
                'data' => $Gaon,
                'message' => 'Gaon Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Gaon Not Found',
            ]);
        }
    }

    //Delete Gaon
    public function destroy($gaonId)
    {
        $Gaon = Gaon::find($gaonId);

        if ($Gaon) {
            $Gaon->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Gaon deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Gaon Not Found',
            ]);
        }
    }
    
    
     //View Gaon By ZillaParishad Id
    public function getGaonByZillaParishad($zillaParishad)
    {
        
        $Gaon = DB::table('gaon AS G')
            ->select('G.id', 'G.gaonName')
            ->leftJoin('taluka_panchayats AS TP', 'TP.id', '=', 'G.talukaPanchayatId')
            ->leftJoin('zilla_parishads AS ZP', 'ZP.id', '=', 'TP.zillaParishadId')
             // ->where('ZP.id', '=', 1)
            ->where('ZP.id', $zillaParishad)
            ->get();
        
       /* $Gaon = Gaon::select('gaon.id as gaonId', 'gaon.gaonName', 'gaon.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName','gaon.created_by','gaon.updated_by')
            ->leftjoin('taluka_panchayats', 'gaon.talukaPanchayatId', "=", 'taluka_panchayats.id')
            ->where('gaon.talukaPanchayatId', $talukaPanchayatId)->get();*/

        if (count($Gaon)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $Gaon,
                'message' => 'Gaon Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Gaon Not Found',
            ]);
        }
    }
    
    
}
