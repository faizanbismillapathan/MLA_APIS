<?php

namespace App\Http\Controllers;

use App\Models\VillageDevelopmentWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class VillageDevelopmentWorkController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'GoanID' => 'required',
            'Work_Name' => '',
            'Price' => '',
            'Head_Year' => '',
            'Work_Reference' => '',
            'Status' => '',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $data = VillageDevelopmentWork::create(array_merge($Validator->validated(), ['isActive' => '1']));
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

    public function viewByGaonId($gaonId)
    {
        $data = DB::table('Village_Development_works as VD')
            ->select('VD.Village_Development_works_ID', 'VD.GoanID', 'G.gaonName', 'VD.Work_Name', 'VD.Price',
                'VD.Head_Year', 'VD.Work_Reference', 'VD.Status', 'VD.created_by','VD.updated_by')
            ->leftJoin('gaon as G', 'G.id', '=', 'VD.GoanID')
            ->where('VD.GoanID', 2)
            ->where('VD.isActive', 1)
            ->get();
        foreach ($data as $item) {
            $res = [
                'Village_Development_works_ID' => $item->Village_Development_works_ID,
                'GoanID' => $item->GoanID,
                'gaonName' => $item->gaonName,
                'Work_Name' => $item->Work_Name,
                'Price' => $item->Price,
                'Head_Year' => $item->Head_Year,
                'Work_Reference' => $item->Work_Reference,
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

    public function destroy($id)
    {
        $data = VillageDevelopmentWork::find($id);
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
