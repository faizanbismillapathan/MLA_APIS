<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RegisterInward;
use App\Models\RegisterInwardAdhikari;
use App\Models\Images;
use Illuminate\Support\Facades\DB;

class RegisterInwardController extends Controller
{
    //Add Register Inward
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
            'documentFrom' => '',
            'deliveredBy' => '',
            'document' => '',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }

        // Add Register Inward
        $RegisterInward = new RegisterInward();
        $RegisterInward->letterTypeId = $request->letterTypeId;
        $RegisterInward->departmentId = $request->departmentId;
        $RegisterInward->fileNumber = $request->fileNumber;
        $RegisterInward->priority = $request->priority;
        $RegisterInward->letterReleaseDate = $request->letterReleaseDate;
        $RegisterInward->note = $request->note;
        $RegisterInward->assemblyId = $request->assemblyId;
        $RegisterInward->cityType = $request->cityType;
        $RegisterInward->wardId = $request->wardId;
        $RegisterInward->wardAreaId = $request->wardAreaId;
        $RegisterInward->zillaParishadId = $request->zillaParishadId;
        $RegisterInward->talukaPanchayatId = $request->talukaPanchayatId;
        $RegisterInward->gaonId = $request->gaonId;
        $RegisterInward->documentFrom = $request->documentFrom;
        $RegisterInward->deliveredBy = $request->deliveredBy;
        $RegisterInward->created_by = $request->created_by;
        $RegisterInward->save();

        //  For document
        if ($request->document) {
            $document = $request->document;
            $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/RegisterInwardDocument'), $new_name);
            $RegisterInwardDocument = new Images;
            $RegisterInwardDocument->documentName = $new_name;
            $RegisterInwardDocument->documentType = 'RegisterInward';
            $RegisterInwardDocument->typeId = $RegisterInward->id;
            $RegisterInwardDocument->save();
        }

        if ($RegisterInward) {
            return response()->json([
                'code' => 200,
                'data' => $RegisterInward,
                'message' => 'Register Inward Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Register Inward Not Added',
            ]);
        }
    }

    // View All RegisterInward
    public function index()
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,wardId,wardAreaId,zillaParishadId,talukaPanchayatId,gaonId,documentFrom,deliveredBy,document,adhikariId

        $RegisterInward = RegisterInward::select('registerInward.id as registerInwardId', 'registerInward.letterTypeId', 'letterType.letterTypeName', 'registerInward.departmentId', 'departments.departmentName', 'registerInward.fileNumber','registerInward.priority', 'registerInward.letterReleaseDate', 'registerInward.note', 'registerInward.assemblyId','assembly.assemblyName', 'registerInward.cityType','registerInward.wardId','ward.wardName','registerInward.wardAreaId','wardArea.wardAreaName','registerInward.zillaParishadId','zilla_parishads.zillaParishadName','registerInward.talukaPanchayatId','taluka_panchayats.talukaPanchayatName','registerInward.gaonId','gaon.gaonName','registerInward.documentFrom','df.fname as documentFromFname','df.mname as documentFromMname','df.lname as documentFromLname','registerInward.deliveredBy','df.fname as deliveredByFname','df.mname as deliveredByMname','df.lname as deliveredByLname','registerInward.created_by','registerInward.updated_by')
            ->leftjoin('letterType', 'registerInward.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'registerInward.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'registerInward.departmentId', 'departments.id')
            ->leftjoin('gaon', 'registerInward.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'registerInward.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'registerInward.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'registerInward.wardId', 'ward.id')
            ->leftjoin('wardArea', 'registerInward.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'registerInward.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'registerInward.deliveredBy', 'db.id')
            ->get();

        if (count($RegisterInward) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $RegisterInward,
                'message' => 'Register Inward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Inward Not Found',
            ]);
        }
    }

    // View All RegisterInward with pagination
    public function viewRegisterInwardByPagination($pageNo)
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,wardId,wardAreaId,zillaParishadId,talukaPanchayatId,gaonId,documentFrom,deliveredBy,document,adhikariId
        $count = RegisterInward::count();
        $limit = 25;
        $totalPage = ceil($count / $limit);
        $data = RegisterInward::select('registerInward.id as registerInwardId', 'registerInward.letterTypeId', 'letterType.letterTypeName', 'registerInward.departmentId', 'departments.departmentName', 'registerInward.fileNumber','registerInward.priority', 'registerInward.letterReleaseDate', 'registerInward.note', 'registerInward.assemblyId','assembly.assemblyName', 'registerInward.cityType','registerInward.wardId','ward.wardName','registerInward.wardAreaId','wardArea.wardAreaName','registerInward.zillaParishadId','zilla_parishads.zillaParishadName','registerInward.talukaPanchayatId','taluka_panchayats.talukaPanchayatName','registerInward.gaonId','gaon.gaonName','registerInward.documentFrom','df.fname as documentFromFname','df.mname as documentFromMname','df.lname as documentFromLname','registerInward.deliveredBy','df.fname as deliveredByFname','df.mname as deliveredByMname','df.lname as deliveredByLname','registerInward.created_by','registerInward.updated_by')
            ->leftjoin('letterType', 'registerInward.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'registerInward.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'registerInward.departmentId', 'departments.id')
            ->leftjoin('gaon', 'registerInward.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'registerInward.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'registerInward.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'registerInward.wardId', 'ward.id')
            ->leftjoin('wardArea', 'registerInward.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'registerInward.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'registerInward.deliveredBy', 'db.id')
            ->orderBy('registerInward.id')
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY registerInward.id) AS RowNum');

            $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
            ->mergeBindings($data->getQuery())
            ->whereBetween('RowNum', [($pageNo - 1) * $limit + 1, $pageNo * $limit]);

        $RegisterInward = $subquery->get();
        foreach ($RegisterInward as $item) {
            $res = [
                'registerInwardId' => $item->registerInwardId,
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
                'documentFrom' => $item->documentFrom,
                'documentFromFname' => $item->documentFromFname,
                'documentFromMname' => $item->documentFromMname,
                'documentFromLname' => $item->documentFromLname,
                'deliveredBy' => $item->deliveredBy,
                'deliveredByFname' => $item->deliveredByFname,
                'deliveredByMname' => $item->deliveredByMname,
                'deliveredByLname' => $item->deliveredByLname,
            ];
            $result[] = $res;
        }
        if (count($RegisterInward) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'count'=>$count,
                'Total Page'=>$totalPage,
                'message' => 'Register Inward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Inward Not Found',
            ]);
        }
    }
    //View Register Inward By Id
    public function show($registerInwardId)
    {
        $RegisterInward = RegisterInward::select('registerInward.id as registerInwardId', 'registerInward.letterTypeId', 'letterType.letterTypeName', 'registerInward.departmentId', 'departments.departmentName', 'registerInward.fileNumber','registerInward.priority', 'registerInward.letterReleaseDate', 'registerInward.note', 'registerInward.assemblyId','assembly.assemblyName', 'registerInward.cityType','registerInward.wardId','ward.wardName','registerInward.wardAreaId','wardArea.wardAreaName','registerInward.zillaParishadId','zilla_parishads.zillaParishadName','registerInward.talukaPanchayatId','taluka_panchayats.talukaPanchayatName','registerInward.gaonId','gaon.gaonName','registerInward.documentFrom','df.fname as documentFromFname','df.mname as documentFromMname','df.lname as documentFromLname','registerInward.deliveredBy','df.fname as deliveredByFname','df.mname as deliveredByMname','df.lname as deliveredByLname','registerInward.created_by','registerInward.updated_by')
            ->leftjoin('letterType', 'registerInward.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'registerInward.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'registerInward.departmentId', 'departments.id')
            ->leftjoin('gaon', 'registerInward.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'registerInward.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'registerInward.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'registerInward.wardId', 'ward.id')
            ->leftjoin('wardArea', 'registerInward.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'registerInward.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'registerInward.deliveredBy', 'db.id')
            ->where('registerInward.id', $registerInwardId)
            ->get();

        if (count($RegisterInward) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $RegisterInward[0],
                'message' => 'Register Inward Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Inward Not Found',
            ]);
        }
    }

    //Update Register Inward
    public function update(Request $request, $registerInwardId)
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,documentFrom,deliveredBy,document,adhikariId

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
            'documentFrom' => '',
            'deliveredBy' => '',
            'document' => '',
            'updated_by' => 'required',
        ]);

        $RegisterInward = RegisterInward::find($registerInwardId);
        if ($RegisterInward) {
            $RegisterInward->letterTypeId = $request->letterTypeId;
            $RegisterInward->departmentId = $request->departmentId;
            $RegisterInward->fileNumber = $request->fileNumber;
            $RegisterInward->priority = $request->priority;
            $RegisterInward->letterReleaseDate = $request->letterReleaseDate;
            $RegisterInward->note = $request->note;
            $RegisterInward->assemblyId = $request->assemblyId;
            $RegisterInward->cityType = $request->cityType;
            $RegisterInward->wardId = $request->wardId;
            $RegisterInward->wardAreaId = $request->wardAreaId;
            $RegisterInward->zillaParishadId = $request->zillaParishadId;
            $RegisterInward->talukaPanchayatId = $request->talukaPanchayatId;
            $RegisterInward->gaonId = $request->gaonId;
            $RegisterInward->documentFrom = $request->documentFrom;
            $RegisterInward->deliveredBy = $request->deliveredBy;
            $RegisterInward->updated_by = $request->updated_by;
            $RegisterInward->update();

            //  For document
            if ($request->document) {
                $document = $request->document;
                $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('/RegisterInwardDocument'), $new_name);
                $RegisterInwardDocument = new Images;
                $RegisterInwardDocument->documentName = $new_name;
                $RegisterInwardDocument->documentType = 'RegisterInward';
                $RegisterInwardDocument->typeId = $RegisterInward->id;
                $RegisterInwardDocument->save();
            }
            return response()->json([
                'code' => 200,
                'data' => $RegisterInward,
                'message' => 'Register Inward Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Inward Not Found',
            ]);
        }
    }

    //Delete Register Inward
    public function destroy($registerInwardId)
    {
        $RegisterInward = RegisterInward::find($registerInwardId);

        if ($RegisterInward) {
            $RegisterInward->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Register Inward deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Inward Not Found',
            ]);
        }
    }
}
