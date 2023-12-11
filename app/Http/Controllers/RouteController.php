<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use Validator;

class RouteController extends Controller
{
    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'routeName' => 'required',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
      //  $route = Route::create(array_merge($Validator->validated()));
       
          $Route = new Route();
        $Route->routeName = $req->routeName;
        $Route->created_by = $req->userId;
        $Route->save();
       
        if ($Route) {
            return response()->json([
                'code' => 200,
                'data' => $Route,
                'message' => 'Route Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'data' => 'Route Not Added',
            ]);
        }
    }

    public function viewAll()
    {
        $route = Route::all();
        if ($route) {
            return response()->json([
                'code' => 200,
                'data' => $route,
                'message' => 'Route Fetched Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Route Not Fetched',
            ]);
        }
    }

    public function viewById($id)
    {
        $route = Route::select('id','routeName','created_by','updated_by')->where('id',$id)->first();
        if ($route) {
            return response()->json([
                'code' => 200,
                'data' => $route,
                'message' => 'Route Fetched Suceessfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Route Not Found',
            ]);
        }
    }

    public function edit(Request $req, $id)
    {
        $req->validate([
            'routeName' => 'required',
            'userId' => 'required',
        ]);
        $route = Route::find($id);
        if ($route) {
            $route->routeName = $req->routeName;
            $route->updated_by = $req->userId;
            $route->update();
            return response()->json([
                'code' => 200,
                'data' => $route,
                'message' => 'Route Updated Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Route Not Found',
            ]);
        }
    }

    public function destroy($id)
    {
        $route = Route::find($id);
        if ($route) {
            $route->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Route Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Route Not Found',
            ]);
        }
    }
}
