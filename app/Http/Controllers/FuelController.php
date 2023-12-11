<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Fuel;
use Illuminate\Support\Facades\DB;

class FuelController extends Controller
{
    //Add Fuel
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'vehicalId' => '',
            'date' =>'',
            'driverId' => '',
            'fuel' => '',
            'fuelAmount' => '',
            'startReading' => '',
            'endReading' => '',
            'KM' => '',
            'tourDetail' => '',
            'tourReason' => '',
            'maintenanceAmount' => '',
            'maintenanceDetail' => '',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $Fuel = Fuel::create(array_merge(
            $Validator->validated()
        ));
        if ($Fuel) {
            return response()->json([
                'code' => 200,
                'data' => $Fuel,
                'message' => 'Fuel Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Fuel Not Added',
            ]);
        }
    }

    // View All Fuel
   /* public function index()
    {
        $Fuel = Fuel::select('fuel.id as fuelId', 'fuel.vehicalId','vehical.name as vehicalName','vehical.number as vehicalNumber','vehical.fuelType as vehicalFuelType','fuel.vehicalId', 'fuel.driverId','citizens.fname as driverFname','citizens.mname as driverMname','citizens.lname as driverLname','citizens.number as driverNumber', 'fuel.fuel', 'fuel.fuelAmount', 'fuel.startReading', 'fuel.endReading', 'fuel.tourDetail', 'fuel.tourReason', 'fuel.maintenanceAmount', 'fuel.maintenanceDetail')
            ->leftjoin('vehical', 'fuel.vehicalId', "=", 'vehical.id')
            ->leftjoin('citizens', 'fuel.driverId', "=", 'citizens.id')
            ->get();
        if (count($Fuel) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Fuel,
                'message' => 'Fuel Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Fuel Not Found',
            ]);
        }
    }*/
    // Vipul
    //  public function index($pageNo,$pageSize, $vehicleId = null, $FromDate =null, $ToDate = null)
    // {
    //     $Fuel = Fuel::select('fuel.id as fuelId', 'fuel.date', 'fuel.vehicalId','vehical.name as vehicalName','vehical.number as vehicalNumber','vehical.fuelType as vehicalFuelType', 'fuel.driverId','citizens.fname as driverFname','citizens.mname as driverMname','citizens.lname as driverLname','citizens.number as driverNumber', 'fuel.fuel', 'fuel.fuelAmount', 'fuel.startReading', 'fuel.endReading', 'fuel.KM', 'fuel.tourDetail', 'fuel.tourReason', 'fuel.maintenanceAmount', 'fuel.maintenanceDetail')
    //         ->leftjoin('vehical', 'fuel.vehicalId', "=", 'vehical.id')
    //         ->leftjoin('citizens', 'fuel.driverId', "=", 'citizens.id');
            
            
    //     if ($vehicleId !== 'null' && $vehicleId !== null) {
    //         $Fuel->where('fuel.vehicalId', $vehicleId);
    //     }
    //     if ($FromDate !== 'null' && $ToDate !== 'null' && $FromDate !== null && $ToDate !== null) {
    //     $Fuel->whereBetween('fuel.date', [$FromDate, $ToDate]);
    //     }
        
        
    //     $Fuel->orderBy('fuel.id', 'desc')
    //     ->selectRaw('ROW_NUMBER() OVER (ORDER BY fuel.id desc) AS RowNum');
            
            
    //     $count = $Fuel->count();
    //   //  $limit = 25;
    //     $totalPage = ceil($count / $pageSize);
        
    //      $subquery = DB::table(DB::raw("({$Fuel->toSql()}) as sub"))
    //         ->mergeBindings($Fuel->getQuery()) // Use getQuery() to get the underlying Query\Builder
    //         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);
    
    //      $Fuel = $subquery->get();
    //     if (count($Fuel) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $Fuel,
    //             'currentPage'=>$pageNo,
    //             'count' => $count,
    //             'totalPage' => $totalPage,
    //             'message' => 'Data Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Data Not Found',
    //         ]);
    //     }
    // }
    
    public function index($pageNo, $pageSize, $vehicleId = null, $FromDate = null, $ToDate = null)
{
    $Fuel = Fuel::select(
        'fuel.id as fuelId',
        'fuel.date',
        'fuel.vehicalId',
        'vehical.name as vehicalName',
        'vehical.number as vehicalNumber',
        'vehical.fuelType as vehicalFuelType',
        'fuel.driverId',
        'citizens.fname as driverFname',
        'citizens.mname as driverMname',
        'citizens.lname as driverLname',
        'citizens.number as driverNumber',
        'fuel.fuel',
        'fuel.fuelAmount',
        'fuel.startReading',
        'fuel.endReading',
        'fuel.KM',
        'fuel.tourDetail',
        'fuel.tourReason',
        'fuel.maintenanceAmount',
        'fuel.maintenanceDetail'
    )
        ->leftjoin('vehical', 'fuel.vehicalId', "=", 'vehical.id')
        ->leftjoin('citizens', 'fuel.driverId', "=", 'citizens.id');

    if ($vehicleId !== 'null' && $vehicleId !== null) {
        $Fuel->where('fuel.vehicalId', $vehicleId);
    }

    if ($FromDate !== 'null' && $ToDate !== 'null' && $FromDate !== null && $ToDate !== null) {
        $Fuel->whereBetween('fuel.date', [$FromDate, $ToDate]);
    }

    $Fuel->orderBy('fuel.id', 'desc');

    $count = $Fuel->count();
    $totalPage = ceil($count / $pageSize);

    $Fuel = $Fuel
        ->offset(($pageNo - 1) * $pageSize)
        ->limit($pageSize)
        ->get();

    if ($Fuel->isNotEmpty()) {
        return response()->json([
            'code' => 200,
            'data' => $Fuel,
            'currentPage' => $pageNo,
            'count' => $count,
            'totalPage' => $totalPage,
            'message' => 'Data Fetched',
        ]);
    } else {
        return response()->json([
            'code' => 404,
            'data' => [],
            'message' => 'Data Not Found',
        ]);
    }
}

    
    

    //View Fuel By Id
    public function show($fuelId)
    {
        $Fuel = Fuel::select('fuel.id as fuelId', 'fuel.date', 'fuel.vehicalId','vehical.name as vehicalName','vehical.number as vehicalNumber','vehical.fuelType as vehicalFuelType','fuel.vehicalId', 'fuel.driverId','citizens.fname as driverFname','citizens.mname as driverMname','citizens.lname as driverLname','citizens.number as driverNumber', 'fuel.fuel', 'fuel.fuelAmount', 'fuel.startReading', 'fuel.endReading', 'fuel.KM', 'fuel.tourDetail', 'fuel.tourReason', 'fuel.maintenanceAmount', 'fuel.maintenanceDetail')
            ->leftjoin('vehical', 'fuel.vehicalId', "=", 'vehical.id')
            ->leftjoin('citizens', 'fuel.driverId', "=", 'citizens.id')
            ->where('fuel.id', $fuelId)->get();
           

        if (count($Fuel) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Fuel[0],
                'message' => 'Fuel Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Fuel Not Found',
            ]);
        }
    }
    
     //View Fuel By vehicalId
    public function showVehicleIdWise($vehicleId)
    {
        $Fuel = Fuel::select('fuel.id as fuelId', 'fuel.date', 'fuel.vehicalId','vehical.name as vehicalName','vehical.number as vehicalNumber','vehical.fuelType as vehicalFuelType','fuel.vehicalId', 'fuel.driverId','citizens.fname as driverFname','citizens.mname as driverMname','citizens.lname as driverLname','citizens.number as driverNumber', 'fuel.fuel', 'fuel.fuelAmount', 'fuel.startReading', 'fuel.endReading', 'fuel.KM', 'fuel.tourDetail', 'fuel.tourReason', 'fuel.maintenanceAmount', 'fuel.maintenanceDetail')
            ->leftjoin('vehical', 'fuel.vehicalId', "=", 'vehical.id')
            ->leftjoin('citizens', 'fuel.driverId', "=", 'citizens.id')
            ->where('fuel.vehicalId', $vehicleId)
           ->orderBy('fuel.id', 'desc')
           ->get();

        if (count($Fuel) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Fuel[0],
                'message' => 'Fuel Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Fuel Not Found',
            ]);
        }
    }
    

    //Update Vehical
    public function update(Request $request, $fuelId)
    {
        $request->validate([
            'vehicalId' => '',
            'driverId' => '',
            'date' => '',
            'fuel' => '',
            'fuelAmount' => '',
            'startReading' => '',
            'endReading' => '',
            'KM' => '',
            'tourDetail' => '',
            'tourReason' => '',
            'maintenanceAmount' => '',
            'maintenanceDetail' => '',
            'updated_by' => 'required',
        ]);

        $Fuel = Fuel::find($fuelId);
        if ($Fuel) {
            // vehicalId,driverId,fuel,fuelAmount,startReading,endReading,tourDetail,tourReason,maintenanceAmount,maintenanceDetail,
            $Fuel->vehicalId = $request->vehicalId;
            $Fuel->driverId = $request->driverId;
            $Fuel->fuel = $request->fuel;
            $Fuel->fuelAmount = $request->fuelAmount;
            $Fuel->startReading = $request->startReading;
            $Fuel->endReading = $request->endReading;
            $Fuel->tourDetail = $request->tourDetail;
            $Fuel->tourReason = $request->tourReason;
            $Fuel->maintenanceAmount = $request->maintenanceAmount;
            $Fuel->maintenanceDetail = $request->maintenanceDetail;
            $Fuel->updated_by = $request->updated_by;
            $Fuel->update();

            return response()->json([
                'code' => 200,
                'data' => $Fuel,
                'message' => 'Fuel Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Fuel Not Found',
            ]);
        }
    }

    //Delete Fuel
    public function destroy($fuelId)
    {
        $Fuel = Fuel::find($fuelId);

        if ($Fuel) {
            $Fuel->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Fuel deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Fuel Not Found',
            ]);
        }
    }
}
