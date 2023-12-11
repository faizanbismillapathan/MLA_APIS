<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ComplaintCategory;

class ComplaintCategoryController extends Controller
{
    //Add Complaint Category
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'complaintCategoryName' => 'required|unique:complaint_category',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $ComplaintCategory = ComplaintCategory::create(array_merge(
        //     $Validator->validated()
        // ));
        
        $ComplaintCategory = new ComplaintCategory();
        $ComplaintCategory->complaintCategoryName = $request->complaintCategoryName;
        $ComplaintCategory->created_by = $request->userId;
        $ComplaintCategory->save();
        

        if ($ComplaintCategory) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintCategory,
                'message' => 'Complaint Category Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Complaint Category Not Added',
            ]);
        }
    }

    // View All Complaint Category
    public function index()
    {
        $ComplaintCategory = ComplaintCategory::select('complaint_category.id as complaintCategoryId', 'complaint_category.complaintCategoryName','complaint_category.created_by','complaint_category.updated_by')->get();
        if (count($ComplaintCategory)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintCategory,
                'message' => 'Complaint Category Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Category Not Found',
            ]);
        }
    }

    //View Ward By Id
    public function show($ComplaintCategoryId)
    {
        $ComplaintCategory = ComplaintCategory::select('complaint_category.id as ComplaintCategoryId', 'complaint_category.complaintCategoryName','complaint_category.created_by','complaint_category.updated_by')->where('complaint_category.id', $ComplaintCategoryId)->get();

        if (count($ComplaintCategory)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintCategory[0],
                'message' => 'Complaint Category Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Category Not Found',
            ]);
        }
    }

    //Update ComplaintCategory
    public function update(Request $request, $complaintCategoryId)
    {
        $request->validate([
            'complaintCategoryName' => 'required',
            'userId' => 'required',
        ]);

        $ComplaintCategory = ComplaintCategory::find($complaintCategoryId);
        if ($ComplaintCategory) {
            $ComplaintCategory->complaintCategoryName = $request->complaintCategoryName;
            $ComplaintCategory->updated_by = $request->userId;
            $ComplaintCategory->update();

            return response()->json([
                'code' => 200,
                'data' => $ComplaintCategory,
                'message' => 'Complaint Category Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Category Not Found',
            ]);
        }
    }

    //Delete ComplaintCategory
    public function destroy($complaintCategoryId)
    {
        $ComplaintCategory = ComplaintCategory::find($complaintCategoryId);

        if ($ComplaintCategory) {
            $ComplaintCategory->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Complain tCategory deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Category Not Found',
            ]);
        }
    }
}
