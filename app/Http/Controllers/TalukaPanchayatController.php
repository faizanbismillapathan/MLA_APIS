<?php

namespace App\Http\Controllers;

use App\Models\taluka_panchayat;
use Illuminate\Http\Request;
use Validator;
use DB;

class TalukaPanchayatController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'talukaPanchayatName' => 'required | unique:taluka_panchayats',
            'zillaParishadId' => 'required',
            'userId' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->tojson(), 400);
        }
      //  $data = taluka_panchayat::create(array_merge($validator->validated()));
      
        $taluka_panchayat = new taluka_panchayat();
        $taluka_panchayat->talukaPanchayatName = $request->talukaPanchayatName;
        $taluka_panchayat->zillaParishadId = $request->zillaParishadId;
        $taluka_panchayat->created_by = $request->userId;
        $taluka_panchayat->save();
      
        if ($taluka_panchayat) {
            return response()->json([
                'code' => 200,
                'data' => $taluka_panchayat,
                'message' => 'Taluka Panchayat Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Taluka Panchayat Not added',
            ]);
        }
    }

    public function viewAll()
    {
        // $data = taluka_panchayat::all();
        $data = DB::select("SELECT TP.id, TP.talukaPanchayatName, ZP.zillaParishadName, ZP.id as zillaParishadId, TP.created_by,TP.updated_by FROM taluka_panchayats as TP left JOIN zilla_parishads as ZP ON ZP.id = TP.zillaParishadId");
        // $data = taluka_panchayat::select('taluka_panchayats.id', 'taluka_panchayats.talukaPanchayatName', 'taluka_panchayats.zillaParishadId', 'zilla_parishads.zillaParishadName')
        // ->leftjoin('zilla_parishads', 'zilla_parishads.id', '=', 'taluka_panchayats.id')->get();
        if ($data) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => "Taluka Panchayat Fetch Successfully",
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Taluka Panchayat Not Found',
            ]);
        }
    }

    public function viewById($id)
    {
        // $taluka_panchayat = taluka_panchayat::find($id);
        // $taluka_panchayat = taluka_panchayat::select('taluka_panchayats.id', 'taluka_panchayats.talukaPanchayatName', 'taluka_panchayats.zillaParishadId', 'zilla_parishads.zillaParishadName')
        // ->join('zilla_parishads', 'zilla_parishads.id', '=', 'taluka_panchayats.id')->where('taluka_panchayats.id','=', $id)->get();
        // $taluka_panchayat = taluka_panchayat::select('taluka_panchayats.id', 'taluka_panchayats.talukaPanchayatName', 'zilla_parishads.id', 'zilla_parishads.zillaParishadName')
        // ->leftjoin('zilla_parishads', 'zilla_parishads.id', '=', 'taluka_panchayats.id')->where('taluka_panchayats.id', $id)->get();
        $taluka_panchayat = DB::select("SELECT TP.id, TP.talukaPanchayatName, ZP.zillaParishadName, ZP.id as zillaParishadId , TP.created_by,TP.updated_by FROM taluka_panchayats as TP LEFT JOIN zilla_parishads as ZP ON ZP.id = TP.zillaParishadId WHERE TP.id = $id");
        if ($taluka_panchayat) {
            return response()->json([
                'code' => 200,
                'data' => $taluka_panchayat[0],
                'message' => 'Taluka Panchayat Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Taluka Panchayat Not Found',
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'talukaPanchayatName' => 'required',
            'zillaParishadId' => 'required',
            'userId' => 'required',
        ]);
        $taluka_panchayat = taluka_panchayat::find($id);
        if ($taluka_panchayat) {
            $taluka_panchayat->talukaPanchayatName = $request->talukaPanchayatName;
            $taluka_panchayat->zillaParishadId = $request->zillaParishadId;
            $taluka_panchayat->updated_by = $request->userId;
            $taluka_panchayat->update();
            return response()->json([
                'code' => 200,
                'data' => $taluka_panchayat,
                'message' => 'Taluka Panchayat Updated',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Taluka Panchayat Not Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $taluka_panchayat = taluka_panchayat::find($id);
        if ($taluka_panchayat) {
            $taluka_panchayat->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Taluka Panchayat Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Taluka Panchayat Not Found',
            ]);
        }
    }

    public function talukaPanchayatByZillaParishadId($zillaParishadId)
    {
        // $taluka_panchayat = taluka_panchayat::select('taluka_panchayats.talukaPanchayatName', 'taluka_panchayats.zillaParishadId', 'zilla_parishads.zillaParishadName')
        //                     ->join('zilla_parishads','zilla_parishads.id','=','taluka_panchayats.zillaParishadId')
        //                     ->where('zillaParishadId', $zillaParishadId);

        $taluka_panchayat = taluka_panchayat::select('taluka_panchayats.id','taluka_panchayats.talukaPanchayatName', 'taluka_panchayats.zillaParishadId', 'zilla_parishads.zillaParishadName')
            ->leftjoin('zilla_parishads', 'zilla_parishads.id', '=', 'taluka_panchayats.zillaParishadId')
            ->where('taluka_panchayats.zillaParishadId', $zillaParishadId)
            ->get();

        if ($taluka_panchayat) {
            return response()->json([
                'code' => 200,
                'data' => $taluka_panchayat,
                'message' => 'Taluka Panchatat Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Taluka Panchayat Not Fetched',
            ]);
        }
    }
}
