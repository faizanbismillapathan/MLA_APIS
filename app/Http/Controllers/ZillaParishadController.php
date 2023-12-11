<?php

namespace App\Http\Controllers;

use App\Models\Zilla_Parishad;
use Illuminate\Http\Request;
use Validator;
use DB;

class ZillaParishadController extends Controller
{
    //
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'zillaParishadName' => 'required | unique:zilla_parishads',
            'assemblyId' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        
       // $zillaparishad = Zilla_Parishad::create(array_merge($Validator->validated()));
       
           $Zilla_Parishad = new Zilla_Parishad();
        $Zilla_Parishad->zillaParishadName = $request->zillaParishadName;
        $Zilla_Parishad->assemblyId = $request->assemblyId;
        $Zilla_Parishad->created_by = $request->userId;
        $Zilla_Parishad->save();
       
        if ($Zilla_Parishad) {
            return response()->json([
                'code' => 200,
                'data' => $Zilla_Parishad,
                'message' => 'Zilla Parishad Added',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Zilla Parishad Not Added',
            ]);
        }
    }

    public function viewAll()
    {
        // $zillaparishad = Zilla_Parishad::all();
        // $zillaparishad = Zilla_Parishad::select('zilla_parishads.id', 'zilla_parishads.zillaParishadName', 'zilla_parishads.assemblyId','assembly.assemblyName')
        //     ->join('assembly', 'assembly.id', '=', 'zilla_parishads.id')->get();
        // $zillaparishad = DB::select("SELECT zp.id, zp.zillaParishadName, zp.assemblyId, ambl.assemblyName  FROM `zilla_parishads` as zp JOIN assembly as ambl ON zp.assemblyId = ambl.id");
        $zillaparishad = DB::table('zilla_parishads as zp')
    ->select('zp.id', 'zp.zillaParishadName', 'zp.assemblyId', 'ambl.assemblyName','zp.created_by','zp.updated_by')
    ->leftjoin('assembly as ambl', 'zp.assemblyId', '=', 'ambl.id')
    ->get();

        if ($zillaparishad) {
            return response()->json([
                'code' => 200,
                'data' => $zillaparishad,
                'message' => 'Zilla Parishad Fetched Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Zilla Parishad Not Found',
            ]);
        }
    }

    public function viewById($id)
    {
        // $zillaparishad = Zilla_Parishad::find($id);
        $zillaparishad = Zilla_Parishad::select('zilla_parishads.id', 'zilla_parishads.zillaParishadName', 'zilla_parishads.assemblyId','assembly.assemblyName','zilla_parishads.created_by','zilla_parishads.updated_by')
            ->leftjoin('assembly', 'assembly.id', '=', 'zilla_parishads.id')->where('zilla_parishads.id', $id)->first();
        if ($zillaparishad) {
            return response()->json([
                'code' => 200,
                'data' => $zillaparishad,
                'message' => 'Zilla Parishad Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'messgae' => 'Zilla Parishad Not Found',
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'zillaParishadName' => 'required',
            'assemblyId' => 'required',
            'userId' => 'required',
        ]);
        $zillaparishad = Zilla_Parishad::find($id);
        if ($zillaparishad) {
            $zillaparishad->zillaParishadName = $request->zillaParishadName;
            $zillaparishad->assemblyId = $request->assemblyId;
            $zillaparishad->updated_by = $request->userId;
            $zillaparishad->update();
            return response()->json([
                'code' => 200,
                'data' => $zillaparishad,
                'message' => 'Zilla Parishad Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Zilla Parishad Not Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $zillaparishad = Zilla_Parishad::find($id);
        if ($zillaparishad) {
            $zillaparishad->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Zilla Parishad Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Zilla Parishad Not Found',
            ]);
        }
    }

    public function zillaParishadByassemblyId($assemblyId)
    {
        $zillaparishad = Zilla_Parishad::where('assemblyId', $assemblyId)->get();
        if ($zillaparishad) {
            return response()->json([
                'code' => 200,
                'data' => $zillaparishad,
                'message' => 'Zilla Parishad Found',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Zilla Parishad Not Found',
            ]);
        }
    }
}
