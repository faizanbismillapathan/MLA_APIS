<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LetterType;

class LetterTypeController extends Controller
{
    //Add Letter Type
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'letterTypeName' => 'required',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $LetterType = LetterType::create(array_merge(
            $Validator->validated(),
        ));

        if ($LetterType) {
            return response()->json([
                'code' => 200,
                'data' => $LetterType,
                'message' => 'Letter Type Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Letter Type Not Added',
            ]);
        }
    }

    // View All Letter Type
    public function index()
    {
        $LetterType = LetterType::select('letterType.id as letterTypeId', 'letterType.letterTypeName','letterType.created_by','letterType.updated_by')->get();
        if (count($LetterType)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $LetterType,
                'message' => 'Letter Type Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Letter Type Not Found',
            ]);
        }
    }

    //View Letter Type By Id
    public function show($letterTypeId)
    {
        $LetterType = LetterType::select('letterType.id as letterTypeId', 'letterType.letterTypeName','letterType.created_by','letterType.updated_by')->where('letterType.id', $letterTypeId)->get();

        if (count($LetterType)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $LetterType[0],
                'message' => 'Letter Type Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Letter Type Not Found',
            ]);
        }
    }

    //Update LetterType
    public function update(Request $request, $letterTypeId)
    {
        $request->validate([
            'letterTypeName' => 'required',
            'updated_by' => 'required',
        ]);

        $LetterType = LetterType::find($letterTypeId);
        if ($LetterType) {
            $LetterType->letterTypeName = $request->letterTypeName;
            $LetterType->updated_by = $request->updated_by;
            $LetterType->update();

            return response()->json([
                'code' => 200,
                'data' => $LetterType,
                'message' => 'Letter Type Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Letter Type Not Found',
            ]);
        }
    }

    //Delete LetterType
    public function destroy($letterTypeId)
    {
        $LetterType = LetterType::find($letterTypeId);

        if ($LetterType) {
            $LetterType->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Letter Type deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Letter Type Not Found',
            ]);
        }
    }
}
