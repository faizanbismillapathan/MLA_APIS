<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Register;
use App\Models\Images;
use App\Models\UserPermission;

class RegisterController extends Controller
{
    //Add Register
    public function store(Request $request)
    {
        // $request->validate([
        //     'letterTypeId' => 'required',
        //     'token' => 'nullable',
        //     'departmentId' => 'nullable',
        //     'fileNumber' => 'nullable',
        //     'priority' => 'nullable',
        //     'letterReleaseDate' => 'nullable',
        //     'note' => 'nullable',
        //     'assemblyId' => 'nullable',
        //     'cityType' => 'nullable',
        //     'wardId' => 'nullable',
        //     'wardAreaId' => 'nullable',
        //     'zillaParishadId' => 'nullable',
        //     'talukaPanchayatId' => 'nullable',
        //     'gaonId' => 'nullable',
        //     'documentFrom' => 'nullable',
        //     'deliveredBy' => 'nullable',
        //     'documentFor' => 'nullable',
        //     'receivedBy' => 'nullable',
        //     'registerType' => 'nullable',
        //     'status' => 'nullable',
        //     'outwardId' => 'nullable',
        //     'document' => 'nullable',
        //     'created_by' => 'required',
        // ]);
        // if ($Validator->fails()) {
        //     return response()->json($Validator->errors()->tojson(), 400);
        // }

        // $RegisterData = $request->only([
        //     'letterTypeId', 'departmentId', 'fileNumber', 'priority',
        //     'letterReleaseDate', 'note', 'assemblyId', 'cityType', 'wardId',
        //     'wardAreaId', 'zillaParishadId', 'talukaPanchayatId', 'gaonId',
        //     'documentFrom', 'deliveredBy', 'documentFor', 'receivedBy',
        //     'registerType', 'status', 'outwardId', 'created_by',
        // ]);
        // Add Register
        $data = '';
        if ($request->registerType == 'Inward') {
            $test = Register::where('registerType', 'Inward')
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get();
            $data = substr($test[0]['token'], strpos($test[0]['token'], "-") + 1) + 1;
        }
        $Register = new Register();
        $Register->letterTypeId = $request->letterTypeId;
        $Register->token = ($request->registerType == 'Inward') ? 'IR-'. $data : ($request->token);
        $Register->departmentId = $request->departmentId;
        $Register->fileNumber = $request->fileNumber;
        $Register->priority = $request->priority;
        $Register->letterReleaseDate = $request->letterReleaseDate;
        $Register->note = $request->note;
        $Register->assemblyId = $request->assemblyId;
        $Register->cityType = $request->cityType;
        $Register->wardId = $request->wardId;
        $Register->wardAreaId = empty( $request->wardAreaId) ? null : $request->wardAreaId;
        $Register->zillaParishadId = empty( $request->zillaParishadId) ? null : $request->zillaParishadId;
        $Register->talukaPanchayatId = empty( $request->talukaPanchayatId) ? null : $request->talukaPanchayatId;
        $Register->gaonId =empty( $request->gaonId) ? null : $request->gaonId;
        $Register->documentFrom = $request->documentFrom;
        $Register->deliveredBy = $request->deliveredBy;
        $Register->documentFor = $request->documentFor;
        $Register->receivedBy = $request->receivedBy;
        $Register->registerType = $request->registerType;
        $Register->status = $request->status;
        $Register->outwardId = $request->outwardId;
        $Register->created_by = $request->created_by;
        $Register->save();



        // if ($request->registerType == 'Inward') {
        //     $test = Register::where('registerType', 'Inward')
        //         ->orderBy('id', 'desc')
        //         ->limit(1)
        //         ->offset(1)
        //         ->get();
        //     if (Register::count() == 0) {
        //         $Register->update(['token' => 'IR-1']);
        //     } elseif ($test) {
        //         $data = substr($test['token'], strpos($test['token'], "-") + 1) + 1;
        //         $Register->update(['token' => $data]);
        //     }
        // }
        // Token
        // if Register::count==0 then add Ir-1
        // if Register::
        // if ($request->registerType == 'Outward') {
        //     $Register = Register::create($RegisterData);
        //     $Register->update(['token' => $request->outwardId]);
        // } else {
        //     $Register = Register::create($RegisterData);
        // $test = Register::where('registerType', 'Inward')
        //     ->orderBy('id', 'desc')
        //     ->first();
        //     if (Register::count() == 0) {
        //         $Register->update(['token' => 'IR-1']);
        //     } elseif ($test) {
        //         $data = substr($test['token'], strpos($test['token'], "-") + 1) + 1;
        //         $Register->update(['token' => $data]);
        //     }
        // }

        $RegisterDocument = null;
        //  For document
        // if ($request->document) {
        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $document = $request->document;
            // $new_name = strstr($request->file('document')->getClientOriginalName(), '.', true)  . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
            $new_name = strstr($request->file('document')->getClientOriginalName(), '.', true)  . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/RegisterDocument'), $new_name);
            $RegisterDocument = new Images;
            $RegisterDocument->documentName = $new_name;
            $RegisterDocument->documentType = 'Register';
            $RegisterDocument->typeId = $Register->id;
            $RegisterDocument->save();
        }
        // else{
        //     $RegisterDocument = new Images;
        //     $RegisterDocument->documentName = null;
        //     $RegisterDocument->documentType = 'Register';
        //     $RegisterDocument->typeId = $Register->id;
        //     $RegisterDocument->isActive = 1;
        //     $RegisterDocument->save();
        // }

        // if ($request->hasFile('documentName') && $request->file('documentName')->isValid()) {
        //     $fileName = $request->file('documentName');
        //     $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
        //     $name = pathinfo($documentName, PATHINFO_FILENAME);
        //     $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
        //     $path = $fileName->move(public_path('/RegisterDocument'), $new_name);
        //     $image = new Images;
        //     $image->documentName = $new_name;
        //     $image->documentType = 'Register';
        //     $image->typeId = $Register->id;
        //     $image->isActive = 1;
        //     $image->save();
        // } else {
        //     $image->documentName = null;
        //     $image->documentType = 'Register';
        //     $image->typeId = $Register->id;
        //     $image->isActive = 1;
        //     $image->save();
        // }


        if ($Register) {
            return response()->json([
                'code' => 200,
                'data' => $Register,
                'document' => $RegisterDocument,
                'token' => $data ? $data : null,
                // 'document' => $RegisterDocument ? $RegisterDocument : null,
                'message' => 'Register Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'token' => $data,
                'data' => [],
                'message' => 'Register Not Added',
            ]);
        }
    }




    // View All Register
    public function index()
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,wardId,wardAreaId,zillaParishadId,talukaPanchayatId,gaonId,documentFrom,deliveredBy,documentFor,receivedBy,registerType,document,adhikariId

        $data = Register::select('register.id as registerId', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.priority', 'register.letterReleaseDate', 'register.note', 'register.assemblyId', 'assembly.assemblyName', 'register.cityType', 'register.wardId', 'ward.wardName', 'register.wardAreaId', 'wardArea.wardAreaName', 'register.zillaParishadId', 'zilla_parishads.zillaParishadName', 'register.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'register.gaonId', 'gaon.gaonName', 'register.documentFrom', 'df.fname as documentFromFname', 'df.mname as documentFromMname', 'df.lname as documentFromLname', 'register.deliveredBy', 'df.fname as deliveredByFname', 'df.mname as deliveredByMname', 'df.lname as deliveredByLname', 'register.documentFor', 'df.fname as documentForFname', 'df.mname as documentForMname', 'df.lname as documentForLname', 'register.receivedBy', 'df.fname as receivedByFname', 'df.mname as receivedByMname', 'df.lname as receivedByLname', 'register.registerType', 'register.status', 'register.outwardId', 'register.created_by', 'register.updated_by')
            ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'register.departmentId', 'departments.id')
            ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'register.wardId', 'ward.id')
            ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id')
            ->get();

        return $this->sendResponse($data);
    }

    // View All Register with pagination
    public function viewRegisterByPagination($pageNo)
    {
        // letterTypeId,departmentId,fileNumber,priority,letterReleaseDate,note,assemblyId,cityType,wardId,wardAreaId,zillaParishadId,talukaPanchayatId,gaonId,documentFrom,deliveredBy,document,adhikariId
        $count = Register::count();
        $limit = 25;
        $pageNo = (int)$pageNo;
        $limit = (int)$limit;
        $totalPage = ceil($count / $limit);
        // $data = Register::select('register.id as registerId', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.priority', 'register.letterReleaseDate', 'register.note', 'register.assemblyId', 'assembly.assemblyName', 'register.cityType', 'register.wardId', 'ward.wardName', 'register.wardAreaId', 'wardArea.wardAreaName', 'register.zillaParishadId', 'zilla_parishads.zillaParishadName', 'register.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'register.gaonId', 'gaon.gaonName', 'register.documentFrom', 'df.fname as documentFromFname', 'df.mname as documentFromMname', 'df.lname as documentFromLname', 'register.deliveredBy', 'df.fname as deliveredByFname', 'df.mname as deliveredByMname', 'df.lname as deliveredByLname', 'register.documentFor', 'df.fname as documentForFname', 'df.mname as documentForMname', 'df.lname as documentForLname', 'register.receivedBy', 'df.fname as receivedByFname', 'df.mname as receivedByMname', 'df.lname as receivedByLname', 'register.registerType', 'register.created_by', 'register.updated_by')
        $data = Register::select('register.id as registerId', 'register.token', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.letterReleaseDate', 'register.registerType', 'register.status', 'register.outwardId', 'register.note',  'register.created_at')
            ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'register.departmentId', 'departments.id')
            ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'register.wardId', 'ward.id')
            ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id')
            ->orderBy('register.id')
            // ->selectRaw('ROW_NUMBER() OVER (ORDER BY register.id) AS RowNum');
            ->selectRaw('CAST(ROW_NUMBER() OVER (ORDER BY register.id) AS SIGNED) AS RowNum');

        $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
            ->mergeBindings($data->getQuery())
            // ->whereBetween('RowNum', [($pageNo - 1) * $limit + 1, $pageNo * $limit]);
            ->whereBetween('RowNum', [(($pageNo - 1) * $limit) + 1, $pageNo * $limit]);

        $Register = $subquery->get();
        foreach ($Register as $item) {
            $res = [
                'registerId' => $item->registerId,
                'token' => $item->token,
                'letterTypeId' => $item->letterTypeId,
                'letterTypeName' => $item->letterTypeName,
                'departmentId' => $item->departmentId,
                'departmentName' => $item->departmentName,
                'fileNumber' => $item->fileNumber,
                'letterReleaseDate' => $item->letterReleaseDate,
                'registerType' => $item->registerType,
                'letterReleaseDate' => $item->letterReleaseDate,
                'note' => $item->note,
                'created_at' => $item->created_at,
            ];
            $result[] = $res;
        }
        // documentFor,receivedBy,registerType
        if (count($Register) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'count' => $count,
                'totalPage' => $totalPage,
                'message' => 'Register Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }
    }
    //View Register  By Id
    public function show($registerId)
    {
        $Register = Register::select('register.id as registerId', 'register.token', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.priority', 'register.letterReleaseDate', 'register.note', 'register.assemblyId', 'assembly.assemblyName', 'register.cityType', 'register.wardId', 'ward.wardName', 'register.wardAreaId', 'wardArea.wardAreaName', 'register.zillaParishadId', 'zilla_parishads.zillaParishadName', 'register.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'register.gaonId', 'gaon.gaonName', 'register.documentFrom', 'register.deliveredBy', 'register.documentFor', 'register.receivedBy', 'register.registerType', 'register.status', 'register.outwardId', 'register.created_by', DB::raw('cb.fname as createdByFname'), DB::raw('cb.mname as createdByMname'), DB::raw('cb.lname as createdByLname'), 'register.updated_by', DB::raw('ub.fname as updatedByFname'), DB::raw('ub.mname as updatedByMname'), DB::raw('ub.lname as updatedByLname'), 'register.created_at')
            ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'register.departmentId', 'departments.id')
            ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'register.wardId', 'ward.id')
            ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
            ->leftJoin('citizens as cb', 'cb.id', '=', 'register.created_by')
            ->leftJoin('citizens as ub', 'ub.id', '=', 'register.updated_by')
            ->where('register.id', $registerId)
            ->get();

        // Document
        $Documents = Images::select('images.typeId as registerId', 'images.documentName')->where('images.typeId', $registerId)->where('images.documentType', 'Register')->get();

        if (count($Documents) != 0) {
            foreach ($Documents as $Document) {
                $res = [
                    'registerId' => $Document->registerId,
                    'document' => 'https://mlaapi.orisunlifescience.com/public/RegisterDocument/' . $Document->documentName,
                    'documentName' => $Document->documentName
                ];
                $result[] = $res;
            }
        } else {
            $result = null;
        }

        $documentFrom = Register::select('c.id', 'c.fname', 'c.mname', 'c.lname', 'c.number', 'c.occupation', 'c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName', 'c.cityType')
            ->leftjoin('citizens as c', 'register.documentFrom', 'c.id')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->where('register.id', $registerId)
            ->get();

        $deliveredBy = Register::select('c.id', 'c.fname', 'c.mname', 'c.lname', 'c.number', 'c.occupation', 'c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName', 'c.cityType')
            ->leftjoin('citizens as c', 'register.deliveredBy', 'c.id')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->where('register.id', $registerId)
            ->get();

        $documentFor = Register::select('c.id', 'c.fname', 'c.mname', 'c.lname', 'c.number', 'c.occupation', 'c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName', 'c.cityType')
            ->leftjoin('citizens as c', 'register.documentFor', 'c.id')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->where('register.id', $registerId)
            ->get();

        $receivedBy = Register::select('c.id', 'c.fname', 'c.mname', 'c.lname', 'c.number', 'c.occupation', 'c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName', 'c.cityType')
            ->leftjoin('citizens as c', 'register.receivedBy', 'c.id')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->where('register.id', $registerId)
            ->get();



        if (count($Register) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $Register[0],
                'registerDocument' => $result,
                'documentFrom' => count($documentFrom) != 0 ? $documentFrom[0] : [],
                'deliveredBy' => count($deliveredBy) != 0 ? $deliveredBy[0] : [],
                'documentFor' => count($documentFor) != 0 ? $documentFor[0] : [],
                'receivedBy' => count($receivedBy) != 0 ? $receivedBy[0] : [],
                'message' => 'Register Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }
    }

    //Update Register
    public function update(Request $request, $registerId)
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
            'documentFor' => '',
            'receivedBy' => '',
            'status' => '',
            'outwardId' => '',
            'registerType' => '',
            'document' => '',
            'updated_by' => 'required',
        ]);

        $Register = Register::find($registerId);
        if ($Register) {
            $Register->letterTypeId = $request->letterTypeId;
            $Register->departmentId = $request->departmentId;
            $Register->fileNumber = $request->fileNumber;
            $Register->priority = $request->priority;
            $Register->letterReleaseDate = $request->letterReleaseDate;
            $Register->note = $request->note;
            $Register->assemblyId = $request->assemblyId;
            $Register->cityType = $request->cityType;
            $Register->wardId = $request->wardId;
            $Register->wardAreaId = $request->wardAreaId;
            $Register->zillaParishadId = $request->zillaParishadId;
            $Register->talukaPanchayatId = $request->talukaPanchayatId;
            $Register->gaonId = $request->gaonId;
            $Register->documentFrom = $request->documentFrom;
            $Register->deliveredBy = $request->deliveredBy;
            $Register->documentFor = $request->documentFor;
            $Register->receivedBy = $request->receivedBy;
            $Register->registerType = $request->registerType;
            $Register->status = $request->status;
            $Register->outwardId = $request->outwardId;
            $Register->updated_by = $request->updated_by;
            $Register->update();

            //  For document
            if ($request->document) {
                $document = $request->document;
                $new_name = strstr($request->file('document')->getClientOriginalName(), '.', true)  . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('/RegisterDocument'), $new_name);
                $RegisterDocument = new Images;
                $RegisterDocument->documentName = $new_name;
                $RegisterDocument->documentType = 'Register';
                $RegisterDocument->typeId = $Register->id;
                $RegisterDocument->save();
            }
            return response()->json([
                'code' => 200,
                'data' => $Register,
                'message' => 'Register Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }
    }

    // Update status
    public function updateStatus(Request $request, $registerId)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $Register = Register::find($registerId);
        if ($Register) {
            $Register->status = $request->status;
            $Register->update();
            return response()->json([
                'code' => 200,
                'data' => $Register,
                'message' => 'Status Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details Not Found',
            ]);
        }
    }

    //Delete Register
    public function destroy($registerId)
    {
        $Register = Register::find($registerId);

        if ($Register) {
            $Register->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Register deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }
    }
    // token, status, pageNo, registerType
    // search by token or status
    public function searchRegisterByTokenOrStatus($token = null, $status = null, $pageNo = null, $registerType = null)
    {
        $count = Register::count();
        $limit = 25;
        $pageNo = (int)$pageNo;
        $limit = (int)$limit;
        $totalPage = ceil($count / $limit);

        $query = Register::select('register.id as registerId', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.priority', 'register.letterReleaseDate', 'register.note', 'register.assemblyId', 'assembly.assemblyName', 'register.cityType', 'register.wardId', 'ward.wardName', 'register.wardAreaId', 'wardArea.wardAreaName', 'register.zillaParishadId', 'zilla_parishads.zillaParishadName', 'register.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'register.gaonId', 'gaon.gaonName', 'register.documentFrom', 'df.fname as documentFromFname', 'df.mname as documentFromMname', 'df.lname as documentFromLname', 'register.deliveredBy', 'df.fname as deliveredByFname', 'df.mname as deliveredByMname', 'df.lname as deliveredByLname', 'register.documentFor', 'df.fname as documentForFname', 'df.mname as documentForMname', 'df.lname as documentForLname', 'register.receivedBy', 'df.fname as receivedByFname', 'df.mname as receivedByMname', 'df.lname as receivedByLname', 'register.registerType', 'register.status', 'register.outwardId', 'register.created_by', 'register.updated_by')
            ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'register.departmentId', 'departments.id')
            ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'register.wardId', 'ward.id')
            ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id');

        if ($token) {
            $query->where('register.token', $token);
        }

        if ($status) {
            $query->where('register.status', $status);
        }

        if ($registerType) {
            $query->where('register.registerType', $registerType);
        }

        // $data = $query->orderBy('register.id', 'desc')->get();
        // $data = $query->orderBy('register.id', 'desc')->paginate($perPage);
        $data = $query->orderBy('register.id', 'desc')->selectRaw('CAST(ROW_NUMBER() OVER (ORDER BY register.id) AS SIGNED) AS RowNum');
        // return $this->sendResponse($data);

        $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
            ->mergeBindings($data->getQuery())
            // ->whereBetween('RowNum', [($pageNo - 1) * $limit + 1, $pageNo * $limit]);
            ->whereBetween('RowNum', [(($pageNo - 1) * $limit) + 1, $pageNo * $limit]);

        $Register = $subquery->get();
        if ($Register) {
            return response()->json([
                'code' => 200,
                'data' => $Register,
                'currentPage' => $pageNo,
                'count' => $count,
                'totalPage' => $totalPage,
                'message' => 'Register Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }
    }

    //View Register  By Id
    // public function showRegisterByRegisterType($pageNo, $pageSize, $registerType = null, $token = null, $status = null, $person = null)
    // {
    //     /* $count = Register::count();
    //     $limit = 25;
    //     $pageNo = (int)$pageNo;
    //     $limit = (int)$limit;
    //     $totalPage = ceil($count / $limit);*/
    //     // $data = Register::select('register.id as registerId', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.priority', 'register.letterReleaseDate', 'register.note', 'register.assemblyId', 'assembly.assemblyName', 'register.cityType', 'register.wardId', 'ward.wardName', 'register.wardAreaId', 'wardArea.wardAreaName', 'register.zillaParishadId', 'zilla_parishads.zillaParishadName', 'register.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'register.gaonId', 'gaon.gaonName', 'register.documentFrom', 'df.fname as documentFromFname', 'df.mname as documentFromMname', 'df.lname as documentFromLname', 'register.deliveredBy', 'df.fname as deliveredByFname', 'df.mname as deliveredByMname', 'df.lname as deliveredByLname', 'register.documentFor', 'df.fname as documentForFname', 'df.mname as documentForMname', 'df.lname as documentForLname', 'register.receivedBy', 'df.fname as receivedByFname', 'df.mname as receivedByMname', 'df.lname as receivedByLname', 'register.registerType', 'register.created_by', 'register.updated_by')
    //     $data = Register::select('register.id as registerId', 'register.token', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.letterReleaseDate', 'register.registerType', 'register.status', 'register.outwardId', 'register.note',  'register.created_at')
    //         ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
    //         ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
    //         ->leftjoin('departments', 'register.departmentId', 'departments.id')
    //         ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
    //         ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
    //         ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
    //         ->leftjoin('ward', 'register.wardId', 'ward.id')
    //         ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
    //         ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
    //         ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id');

    //     if ($token) {
    //         $data->where('register.token', $token);
    //     }

    //     if ($status) {
    //         $data->where('register.status', $status);
    //     }

    //     if ($registerType) {
    //         $data->where('register.registerType', $registerType);
    //     }
    //     if ($person) {
    //         $data->where('register.documentFrom', $person)
    //             ->orwhere('register.deliveredBy', $person)
    //             ->orwhere('register.documentFor', $person)
    //             ->orwhere('register.receivedBy', $person);
    //     }


    //     $data->orderBy('register.id', 'desc')
    //         // ->where('register.registerType', $registerType)
    //         //->orderBy('register.id')
    //         // ->selectRaw('ROW_NUMBER() OVER (ORDER BY register.id) AS RowNum');
    //         // ->selectRaw('CAST(ROW_NUMBER() OVER (ORDER BY register.id) AS SIGNED) AS RowNum');
    //         ->selectRaw('ROW_NUMBER() OVER (ORDER BY register.id desc) AS RowNum');

    //     $count = $data->count();
    //     $totalPage = ceil($count / $pageSize);

    //     $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
    //         ->mergeBindings($data->getQuery())
    //         // ->whereBetween('RowNum', [($pageNo - 1) * $limit + 1, $pageNo * $limit]);
    //         ->whereBetween('RowNum', [(($pageNo - 1) * $pageSize) + 1, $pageNo * $pageSize]);

    //     $data = $subquery->get();
    //     if (count($data) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $data,
    //             'currentPage' => $pageNo,
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

    /* $Register = $subquery->get();
        foreach ($Register as $item) {
            $res = [
                'registerId' => $item->registerId,
                'token' => $item->token,
                'letterTypeId' => $item->letterTypeId,
                'letterTypeName' => $item->letterTypeName,
                'departmentId' => $item->departmentId,
                'departmentName' => $item->departmentName,
                'fileNumber' => $item->fileNumber,
                'letterReleaseDate' => $item->letterReleaseDate,
                'registerType' => $item->registerType,
                'letterReleaseDate' => $item->letterReleaseDate,
                'note' => $item->note,
                'created_at' => $item->created_at,
            ];
            $result[] = $res;
        }
        // documentFor,receivedBy,registerType
        if (count($Register) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'currentPage'=>$pageNo,
                'count' => $count,
                'totalPage' => $totalPage,
                'message' => 'Register Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }*/
    // $data = Register::select('register.id as registerId', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.priority', 'register.letterReleaseDate', 'register.note', 'register.assemblyId', 'assembly.assemblyName', 'register.cityType', 'register.wardId', 'ward.wardName', 'register.wardAreaId', 'wardArea.wardAreaName', 'register.zillaParishadId', 'zilla_parishads.zillaParishadName', 'register.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'register.gaonId', 'gaon.gaonName', 'register.documentFrom', 'df.fname as documentFromFname', 'df.mname as documentFromMname', 'df.lname as documentFromLname', 'register.deliveredBy', 'df.fname as deliveredByFname', 'df.mname as deliveredByMname', 'df.lname as deliveredByLname', 'register.documentFor', 'df.fname as documentForFname', 'df.mname as documentForMname', 'df.lname as documentForLname', 'register.receivedBy', 'df.fname as receivedByFname', 'df.mname as receivedByMname', 'df.lname as receivedByLname', 'register.registerType', 'register.status', 'register.outwardId', 'register.created_by', 'register.updated_by')
    //     ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
    //     ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
    //     ->leftjoin('departments', 'register.departmentId', 'departments.id')
    //     ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
    //     ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
    //     ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
    //     ->leftjoin('ward', 'register.wardId', 'ward.id')
    //     ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
    //     ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
    //     ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id')
    //     ->where('register.registerType', $registerType)
    //     ->get();
    // return $this->sendResponse($data);
    // }

    public function showRegisterByRegisterType($pageNo, $pageSize, $registerType = null, $token = null, $status = null, $person = null)
    {
        $data = Register::select(
            'register.id as registerId',
            'register.token',
            'register.letterTypeId',
            'letterType.letterTypeName',
            'register.departmentId',
            'departments.departmentName',
            'register.fileNumber',
            'register.letterReleaseDate',
            'register.registerType',
            'register.status',
            'register.outwardId',
            'register.note',
            'register.created_at'
        )
            // ->with(['documentFrom', 'deliveredBy', 'documentFor', 'receivedBy'])
            ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
            ->leftjoin('departments', 'register.departmentId', 'departments.id')
            ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'register.wardId', 'ward.id')
            ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id')
            ->when($token, function ($query, $token) {
                return $query->where('register.token', $token);
            })
            ->when($status, function ($query, $status) {
                return $query->where('register.status', $status);
            })
            ->when($registerType, function ($query, $registerType) {
                return $query->where('register.registerType', $registerType);
            })
            ->when($person, function ($query, $person) {
                return $query->where('register.documentFrom', $person)
                    ->orWhere('register.deliveredBy', $person)
                    ->orWhere('register.documentFor', $person)
                    ->orWhere('register.receivedBy', $person);
            })
            ->orderBy('register.id', 'desc');

        $count = $data->count();
        $totalPage = ceil($count / $pageSize);

        $data = $data
            ->offset(($pageNo - 1) * $pageSize)
            ->limit($pageSize)
            ->get();

        if ($data->isNotEmpty()) {
            return response()->json([
                'code' => 200,
                'data' => $data,
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


    public function viewRegisterStatusCount()
    {
        $counts = DB::table('register')
            ->selectRaw('
                COUNT(id) as totalCount,
                COUNT(CASE WHEN status = "Solved" THEN id END) as solved,
                COUNT(CASE WHEN status = "UnSolved" THEN id END) as unSolved,
                COUNT(CASE WHEN status = "InProgress" THEN id END) as inProgress,
                COUNT(CASE WHEN status = "Hold" THEN id END) as hold,
                COUNT(CASE WHEN status = "Queue" THEN id END) as queue
            ')
            ->where('isActive', 1)
            ->first();

        $array = [
            'solved' => $counts->solved,
            'unSolved' => $counts->unSolved,
            'inProgress' => $counts->inProgress,
            'hold' => $counts->hold,
            'queue' => $counts->queue,
        ];
        return $this->sendResponse($array);
    }

    public function count()
    {
        $counts = Register::selectRaw('COUNT(*) as total_count')
            ->selectRaw('SUM(CASE WHEN registerType = "Inward" THEN 1 ELSE 0 END) as inward_count')
            ->selectRaw('SUM(CASE WHEN registerType = "Outward" THEN 1 ELSE 0 END) as outward_count')
            ->first();
        $array = [
            'totalCount' => $counts->total_count,
            'inwardCount' => $counts->inward_count,
            'outwardCount' => $counts->outward_count,
        ];
        return $this->sendResponse($array);
    }

    public function showRegisterByFilter($letterTypeId = null, $registerType = null, $priority = null, $departmentId = null, $assemblyId = null, $cityType = null, $wardId = null, $wardAreaId = null, $gaonId = null, $talukaPanchayatId = null, $zillaParishadId = null, $fromDate = null, $toDate = null)
    {
        $query = Register::select('register.id as registerId', 'register.token', 'register.letterTypeId', 'letterType.letterTypeName', 'register.departmentId', 'departments.departmentName', 'register.fileNumber', 'register.letterReleaseDate', 'register.registerType', 'register.status', 'register.outwardId', 'register.note',  'register.created_at')
            ->leftjoin('letterType', 'register.letterTypeId', 'letterType.id')
            ->leftjoin('assembly', 'register.assemblyId', 'assembly.id')
            ->leftjoin('departments', 'register.departmentId', 'departments.id')
            ->leftjoin('gaon', 'register.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'register.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'register.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'register.wardId', 'ward.id')
            ->leftjoin('wardArea', 'register.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens as df', 'register.documentFrom', 'df.id')
            ->leftjoin('citizens as db', 'register.deliveredBy', 'db.id');

        if ($letterTypeId) {
            $query->where('register.letterTypeId', $letterTypeId);
        }

        if ($registerType) {
            $query->where('register.registerType', $registerType);
        }

        if ($priority) {
            $query->where('register.priority', $priority);
        }

        if ($departmentId) {
            $query->where('register.departmentId', $departmentId);
        }

        if ($assemblyId) {
            $query->where('register.assemblyId', $assemblyId);
        }

        if ($cityType) {
            $query->where('register.cityType', $cityType);
        }

        if ($wardId) {
            $query->where('register.wardId', $wardId);
        }

        if ($wardAreaId) {
            $query->where('register.wardAreaId', $wardAreaId);
        }

        if ($gaonId) {
            $query->where('register.gaonId', $gaonId);
        }

        if ($talukaPanchayatId) {
            $query->where('register.talukaPanchayatId', $talukaPanchayatId);
        }

        if ($zillaParishadId) {
            $query->where('register.zillaParishadId', $zillaParishadId);
        }

        if ($fromDate && $toDate) {
            $query->whereBetween('register.letterReleaseDate', [$fromDate, $toDate]);
        }

        $query->orderBy('register.id', 'desc');

        $count = $query->count();
        $subquery = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query->getQuery());
        $data = $subquery->get();

        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'count' => $count,
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

    public function sendResponse($data)
    {
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Register Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Register Not Found',
            ]);
        }
    }
}
