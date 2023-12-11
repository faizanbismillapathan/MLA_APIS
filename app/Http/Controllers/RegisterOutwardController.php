<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RegisterOutward;
use App\Models\Images;
use Illuminate\Support\Facades\DB;

class RegisterOutwardController extends Controller
{
    //Add Register Outward
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'letterTypeId' => 'required',
            'departmentId' => '',
            'fileNumber' => '',
            'priority' => '',
            'letterReleaseDate' => '',
            'note' => '',
            'assemblyId' => '',
            'cityType' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'zillaParishadId' => '',
            'talukaPanchayatId' => '',
            'gaonId' => '',
            'documentFor' => '',
            'receivedBy' => '',
            'document' => '',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }

        // Add Register Outward
        $RegisterOutward = new RegisterOutward();
        $RegisterOutward->letterTypeId = $request->letterTypeId;
        $RegisterOutward->departmentId = $request->departmentId;
        $RegisterOutward->fileNumber = $request->fileNumber;
        $RegisterOutward->priority = $request->priority;
        $RegisterOutward->letterReleaseDate = $request->letterReleaseDate;
        $RegisterOutward->note = $request->note;
        $RegisterOutward->assemblyId = $request->assemblyId;
        $RegisterOutward->cityType = $request->cityType;
        $RegisterOutward->wardId = $request->wardId;
        $RegisterOutward->wardAreaId = $request->wardAreaId;
        $RegisterOutward->zillaParishadId = $request->zillaParishadId;
        $RegisterOutward->talukaPanchayatId = $request->talukaPanchayatId;
        $RegisterOutward->gaonId = $request->gaonId;
        $RegisterOutward->documentFor = $request->documentFor;
        $RegisterOutward->receivedBy = $request->receivedBy;
        $RegisterOutward->created_by = $request->created_by;
        $RegisterOutward->save();

        //  For document
        if ($request->document) {
            $document = $request->document;
            $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/RegisterOutwardDocument'), $new_name);
            $RegisterOutwardDocument = new Images;
            $RegisterOutwardDocument->documentName = $new_name;
            $RegisterOutwardDocument->documentType = 'RegisterOutward';
            $RegisterOutwardDocument->typeId = $RegisterOutward->id;
            $RegisterOutwardDocument->save();
        }

        if ($RegisterOutward) {
            return response()->json([
                'code' => 200,
                'data' => $RegisterOutward,
                'message' => 'Register Outward Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Register Outward Not Added',
            ]);
        }
    }

    // View All RegisterOutward
    public function index()
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,wardId,wardAreaId,zillaParishadId,talukaPanchayatId,gaonId,documentFor,receivedBy,document,adhikariId

        $RegisterOutward = RegisterOutward::select('registerOutward.id as registerOutwardId', 'registerOutward.letterTypeId', 'letterType.letterTypeName', 'registerOutward.departmentId', 'departments.departmentName', 'registerOutward.fileNumber','registerOutward.priority', 'registerOutward.letterReleaseDate', 'registerOutward.note', 'registerOutward.assemblyId','assembly.assemblyName', 'registerOutward.cityType','registerOutward.wardId','ward.wardName','registerOutward.wardAreaId','wardArea.wardAreaName','registerOutward.zillaParishadId','zilla_parishads.zillaParishadName','registerOutward.talukaPanchayatId','taluka_panchayats.talukaPanchayatName','registerOutward.gaonId','gaon.gaonName','registerOutward.documentFor','df.fname as documentForFname','df.mname as documentForMname','df.lname as documentForLname','registerOutward.receivedBy','rb.fname as receivedByFname','rb.mname as receivedByMname','rb.lname as receivedByLname','registerOutward.created_by','registerOutward.updated_by')
            ->leftjoin('letterType', 'registerOutward.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'registerOutward.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'registerOutward.departmentId', 'departments.id')
            ->leftjoin('gaon', 'registerOutward.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'registerOutward.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'registerOutward.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'registerOutward.wardId', 'ward.id')
            ->leftjoin('wardArea', 'registerOutward.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'registerOutward.documentFor', 'df.id')
            ->leftjoin('citizens as rb', 'registerOutward.receivedBy', 'rb.id')
            ->get();

        if (count($RegisterOutward) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $RegisterOutward,
                'message' => 'Register Outward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Outward Not Found',
            ]);
        }
    }

    // View All RegisterInward with pagination
    public function viewRegisterOutwardByPagination($pageNo)
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,wardId,wardAreaId,zillaParishadId,talukaPanchayatId,gaonId,documentFrom,deliveredBy,document,adhikariId
        $count = RegisterOutward::count();
        $limit = 25;
        $totalPage = ceil($count / $limit);
        $data = RegisterOutward::select('registerOutward.id as registerOutwardId', 'registerOutward.letterTypeId', 'letterType.letterTypeName', 'registerOutward.departmentId', 'departments.departmentName', 'registerOutward.fileNumber','registerOutward.priority', 'registerOutward.letterReleaseDate', 'registerOutward.note', 'registerOutward.assemblyId','assembly.assemblyName', 'registerOutward.cityType','registerOutward.wardId','ward.wardName','registerOutward.wardAreaId','wardArea.wardAreaName','registerOutward.zillaParishadId','zilla_parishads.zillaParishadName','registerOutward.talukaPanchayatId','taluka_panchayats.talukaPanchayatName','registerOutward.gaonId','gaon.gaonName','registerOutward.documentFor','df.fname as documentForFname','df.mname as documentForMname','df.lname as documentForLname','registerOutward.receivedBy','rb.fname as receivedByFname','rb.mname as receivedByMname','rb.lname as receivedByLname','registerOutward.created_by','registerOutward.updated_by')
            ->leftjoin('letterType', 'registerOutward.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'registerOutward.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'registerOutward.departmentId', 'departments.id')
            ->leftjoin('gaon', 'registerOutward.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'registerOutward.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'registerOutward.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'registerOutward.wardId', 'ward.id')
            ->leftjoin('wardArea', 'registerOutward.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'registerOutward.documentFor', 'df.id')
            ->leftjoin('citizens as rb', 'registerOutward.receivedBy', 'rb.id')
            ->orderBy('registerOutward.id')
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY registerOutward.id) AS RowNum');

            $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
            ->mergeBindings($data->getQuery())
            ->whereBetween('RowNum', [($pageNo - 1) * $limit + 1, $pageNo * $limit]);

        $RegisterOutward = $subquery->get();


        foreach ($RegisterOutward as $item) {
            $res = [
                'registerOutwardId' => $item->registerOutwardId,
                'letterTypeId' => $item->letterTypeId,
                'letterTypeName' => $item->letterTypeName,
                'departmentId' => $item->departmentId,
                'departmentName' => $item->departmentName,
                'fileNumber' => $item->fileNumber,
                'priority' => $item->priority,
                'letterReleaseDate' => $item->letterReleaseDate,
                'note' => $item->note,
                'assemblyId' => $item->assemblyId,
                'assemblyName' => $item->assemblyName,
                'cityType' => $item->cityType,
                'wardId' => $item->wardId,
                'wardName' => $item->wardName,
                'wardAreaId' => $item->wardAreaId,
                'wardAreaName' => $item->wardAreaName,
                'zillaParishadId' => $item->zillaParishadId,
                'zillaParishadName' => $item->zillaParishadName,
                'talukaPanchayatId' => $item->talukaPanchayatId,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'gaonId' => $item->gaonId,
                'gaonName' => $item->gaonName,
                'documentFor' => $item->documentFor,
                'documentForFname' => $item->documentForFname,
                'documentForMname' => $item->documentForMname,
                'documentForLname' => $item->documentForLname,
                'receivedBy' => $item->receivedBy,
                'receivedByFname' => $item->receivedByFname,
                'receivedByMname' => $item->receivedByMname,
                'receivedByLname' => $item->receivedByLname,
            ];
            $result[] = $res;
        }
        if (count($RegisterOutward) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'count'=>$count,
                'Total Page'=>$totalPage,
                'message' => 'Register Outward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Outward Not Found',
            ]);
        }
    }
    //View Register Outward By Id
    public function show($registerOutwardId)
    {
        $RegisterOutward = RegisterOutward::select('registerOutward.id as registerOutwardId', 'registerOutward.letterTypeId', 'letterType.letterTypeName', 'registerOutward.departmentId', 'departments.departmentName', 'registerOutward.fileNumber','registerOutward.priority', 'registerOutward.letterReleaseDate', 'registerOutward.note', 'registerOutward.assemblyId','assembly.assemblyName', 'registerOutward.cityType','registerOutward.wardId','ward.wardName','registerOutward.wardAreaId','wardArea.wardAreaName','registerOutward.zillaParishadId','zilla_parishads.zillaParishadName','registerOutward.talukaPanchayatId','taluka_panchayats.talukaPanchayatName','registerOutward.gaonId','gaon.gaonName','registerOutward.documentFor','df.fname as documentForFname','df.mname as documentForMname','df.lname as documentForLname','registerOutward.receivedBy','rb.fname as receivedByFname','rb.mname as receivedByMname','rb.lname as receivedByLname','registerOutward.created_by','registerOutward.updated_by')
            ->leftjoin('letterType', 'registerOutward.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'registerOutward.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'registerOutward.departmentId', 'departments.id')
            ->leftjoin('gaon', 'registerOutward.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'registerOutward.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'registerOutward.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'registerOutward.wardId', 'ward.id')
            ->leftjoin('wardArea', 'registerOutward.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'registerOutward.documentFor', 'df.id')
            ->leftjoin('citizens as rb', 'registerOutward.receivedBy', 'rb.id')
            ->where('registerOutward.id', $registerOutwardId)
            ->get();

        if (count($RegisterOutward) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $RegisterOutward[0],
                'message' => 'Register Outward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Outward Not Found',
            ]);
        }
    }

    //Update Register Outward
    public function update(Request $request, $registerOutwardId)
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,documentFor,receivedBy,document,adhikariId

        $request->validate([
            'letterTypeId' => '',
            'departmentId' => '',
            'fileNumber' => '',
            'priority' => '',
            'letterReleaseDate' => '',
            'note' => '',
            'assemblyId' => '',
            'cityType' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'zillaParishadId' => '',
            'talukaPanchayatId' => '',
            'gaonId' => '',
            'documentFor' => '',
            'receivedBy' => '',
            'document' => '',
            'updated_by' => 'required',
        ]);

        $RegisterOutward = RegisterOutward::find($registerOutwardId);
        if ($RegisterOutward) {
            $RegisterOutward->letterTypeId = $request->letterTypeId;
            $RegisterOutward->departmentId = $request->departmentId;
            $RegisterOutward->fileNumber = $request->fileNumber;
            $RegisterOutward->priority = $request->priority;
            $RegisterOutward->letterReleaseDate = $request->letterReleaseDate;
            $RegisterOutward->note = $request->note;
            $RegisterOutward->assemblyId = $request->assemblyId;
            $RegisterOutward->cityType = $request->cityType;
            $RegisterOutward->wardId = $request->wardId;
            $RegisterOutward->wardAreaId = $request->wardAreaId;
            $RegisterOutward->zillaParishadId = $request->zillaParishadId;
            $RegisterOutward->talukaPanchayatId = $request->talukaPanchayatId;
            $RegisterOutward->gaonId = $request->gaonId;
            $RegisterOutward->documentFor = $request->documentFor;
            $RegisterOutward->receivedBy = $request->receivedBy;
            $RegisterOutward->updated_by = $request->updated_by;
            $RegisterOutward->update();

            //  For document
            if ($request->document) {
                $document = $request->document;
                $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('/RegisterOutwardDocument'), $new_name);
                $RegisterOutwardDocument = new Images;
                $RegisterOutwardDocument->documentName = $new_name;
                $RegisterOutwardDocument->documentType = 'RegisterOutward';
                $RegisterOutwardDocument->typeId = $RegisterOutward->id;
                $RegisterOutwardDocument->save();
            }
            return response()->json([
                'code' => 200,
                'data' => $RegisterOutward,
                'message' => 'Register Outward Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Outward Not Found',
            ]);
        }
    }

    //Delete Register Outward
    public function destroy($registerOutwardId)
    {
        $RegisterOutward = RegisterOutward::find($registerOutwardId);

        if ($RegisterOutward) {
            $RegisterOutward->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Register Outward deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Outward Not Found',
            ]);
        }
    }
}
