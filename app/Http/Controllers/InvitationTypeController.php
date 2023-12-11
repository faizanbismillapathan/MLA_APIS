<?php

namespace App\Http\Controllers;

use App\Models\InvitationType;
use Illuminate\Http\Request;
use Validator;

class InvitationTypeController extends Controller
{
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'invitationTypeName' => 'required | unique:invitation_types',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
       // $data = InvitationType::create(array_merge($Validator->validated()));
       
          $InvitationType = new InvitationType();
        $InvitationType->invitationTypeName = $request->invitationTypeName;
        $InvitationType->created_by = $request->userId;
        $InvitationType->save();
       
        if ($InvitationType) {
            return response()->json([
                'code' => 200,
                'data' => $InvitationType,
                'message' => 'Invitation Tye Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Invitation Type Not Added',
            ]);
        }
    }

    public function viewAll()
    {
        $data = InvitationType::all();
        if ($data) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Invitation Types Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Type Not Fetched',
            ]);
        }
    }

    public function viewById($id)
    {
        $data = InvitationType::select('id', 'invitationTypeName','created_by','updated_by')->where('id', $id)->first();
        if ($data) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Invitation Type fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Type Not Fetched',
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
         $request->validate([
            'invitationTypeName' => 'required',
            'userId' => 'required',
        ]);
        $data = InvitationType::find($id);
        if ($data) {
            $data->invitationTypeName = $request->invitationTypeName;
            $data->updated_by = $request->userId;
            $data->update();
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Invitation Type Updated Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Type Not Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $data = InvitationType::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Invitation Type Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Type Not Found',
            ]);
        }
    }
}
