<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DevelopmentWork;


class DevelopmentWorkController extends Controller
{
    //Add DevelopmentWork
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'developmentWorkName' => 'required|unique:development_work',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $DevelopmentWork = DevelopmentWork::create(array_merge(
            $Validator->validated()
        ));

        if ($DevelopmentWork) {
            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWork,
                'message' => 'Development Work Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Development Work Not Added',
            ]);
        }
    }

    // View All DevelopmentWork
    public function index()
    {
        $DevelopmentWork = DevelopmentWork::select('development_work.id as developmentWorkId', 'development_work.developmentWorkName','development_work.created_by','development_work.updated_by')->get();
        if (count($DevelopmentWork)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWork,
                'message' => 'Development Work Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Not Found',
            ]);
        }
    }

    //View Ward By Id
    public function show($developmentWorkId)
    {
        $DevelopmentWork = DevelopmentWork::select('development_work.id as developmentWorkId', 'development_work.developmentWorkName','development_work.created_by','development_work.updated_by')->where('development_work.id', $developmentWorkId)->get();

        if (count($DevelopmentWork)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWork[0],
                'message' => 'Development Work Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Not Found',
            ]);
        }
    }

    //Update DevelopmentWork
    public function update(Request $request, $developmentWorkId)
    {
        $request->validate([
            'developmentWorkName' => 'required',
            'updated_by' => 'required',
        ]);

        $DevelopmentWork = DevelopmentWork::find($developmentWorkId);
        if ($DevelopmentWork) {
            $DevelopmentWork->developmentWorkName = $request->developmentWorkName;
            $DevelopmentWork->updated_by = $request->updated_by;
            $DevelopmentWork->update();

            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWork,
                'message' => 'Development Work Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Not Found',
            ]);
        }
    }

    //Delete DevelopmentWork
    public function destroy($developmentWorkId)
    {
        $DevelopmentWork = DevelopmentWork::find($developmentWorkId);

        if ($DevelopmentWork) {
            $DevelopmentWork->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Development Work deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Not Found',
            ]);
        }
    }
}
