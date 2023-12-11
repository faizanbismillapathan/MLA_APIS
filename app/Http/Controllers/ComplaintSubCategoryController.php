<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ComplaintSubCategory;

class ComplaintSubCategoryController extends Controller
{
    //Add Complaint Sub Category
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'complaintSubCategoryName' => 'required',
            'complaintCategoryId' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $ComplaintSubCategory = ComplaintSubCategory::create(array_merge(
        //     $Validator->validated()
        // ));
        
           $ComplaintSubCategory = new ComplaintSubCategory();
        $ComplaintSubCategory->complaintSubCategoryName = $request->complaintSubCategoryName;
        $ComplaintSubCategory->complaintCategoryId = $request->complaintCategoryId;
        $ComplaintSubCategory->created_by = $request->userId;
        $ComplaintSubCategory->save();
        
        
        if ($ComplaintSubCategory) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintSubCategory,
                'message' => 'Complaint Sub Category Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Complaint Sub Category Not Added',
            ]);
        }
    }

    // View All Complaint Sub Category
    public function index()
    {
        $ComplaintSubCategory = ComplaintSubCategory::select('complaint_sub_category.id as complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_sub_category.complaintCategoryId', 'complaint_category.complaintCategoryName','complaint_sub_category.created_by','complaint_sub_category.updated_by')
            ->leftjoin('complaint_category', 'complaint_sub_category.complaintCategoryId', "=", 'complaint_category.id')
            ->get();
        if (count($ComplaintSubCategory)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintSubCategory,
                'message' => 'Complaint Sub Category Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Sub Category Not Found',
            ]);
        }
    }

    //View ComplaintSubCategory By Id
    public function show($complaintSubCategoryId)
    {
        $ComplaintSubCategory = ComplaintSubCategory::select('complaint_sub_category.id as complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_sub_category.complaintCategoryId', 'complaint_category.complaintCategoryName','complaint_sub_category.created_by','complaint_sub_category.updated_by')
            ->leftjoin('complaint_category', 'complaint_sub_category.complaintCategoryId', "=", 'complaint_category.id')
            ->where('complaint_sub_category.id', $complaintSubCategoryId)->get();

        if (count($ComplaintSubCategory)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintSubCategory[0],
                'message' => 'Complaint Sub Category Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Sub Category Not Found',
            ]);
        }
    }

    //View ComplaintSubCategory By Taluka Panchayat Id
    public function getComplaintSubCategoryBycomplaintCategoryId($complaintCategoryId)
    {
        $ComplaintSubCategory = ComplaintSubCategory::select('complaint_sub_category.id as complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_sub_category.complaintCategoryId', 'complaint_category.complaintCategoryName','complaint_sub_category.created_by','complaint_sub_category.updated_by')
            ->leftjoin('complaint_category', 'complaint_sub_category.complaintCategoryId', "=", 'complaint_category.id')
            ->where('complaint_sub_category.complaintCategoryId', $complaintCategoryId)->get();

        if (count($ComplaintSubCategory)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintSubCategory,
                'message' => 'Complaint Sub Category Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Sub Category Not Found',
            ]);
        }
    }

    //Update ComplaintSubCategory
    public function update(Request $request, $complaintSubCategoryId)
    {
        $request->validate([
            'complaintSubCategoryName' => 'required',
            'complaintCategoryId' => 'required',
            'userId' => 'required',
        ]);

        $ComplaintSubCategory = ComplaintSubCategory::find($complaintSubCategoryId);
        if ($ComplaintSubCategory) {
            $ComplaintSubCategory->complaintSubCategoryName = $request->complaintSubCategoryName;
            $ComplaintSubCategory->complaintCategoryId = $request->complaintCategoryId;
            $ComplaintSubCategory->updated_by = $request->userId;
            $ComplaintSubCategory->update();

            return response()->json([
                'code' => 200,
                'data' => $ComplaintSubCategory,
                'message' => 'Complaint Sub Category Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Sub Category Not Found',
            ]);
        }
    }

    //Delete ComplaintSubCategory
    public function destroy($complaintSubCategoryId)
    {
        $ComplaintSubCategory = ComplaintSubCategory::find($complaintSubCategoryId);

        if ($ComplaintSubCategory) {
            $ComplaintSubCategory->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Complaint Sub Category deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Sub Category Not Found',
            ]);
        }
    }
}
