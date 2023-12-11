<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\DevelopmentWorkDetails;
use App\Models\DevelopmentWorkDetailsDetails;
use App\Models\Images;

class DevelopmentWorkDetailsController extends Controller
{
    //Add DevelopmentWorkDetails
    public function store(Request $request)
    {
        // $Validator = Validator::make($request->all(), [
        //     'developmentWorkId' => 'required',
        //     'proposedAmount' => '',
        //     'sanctionedAmount' => 'required',
        //     'workStartDate' => '',
        //     'tentiveFinishDate' => '',
        //     'workStatus' => 'required',
        //     'actualFinishDate' => 'required',
        //     'assemblyId' => 'required',
        //     'cityType' => 'required',
        //     'gaonId' => '',
        //     'talukaPanchayatId' => '',
        //     'zillaParishadId' => '',
        //     'wardId' => '',
        //     'wardAreaId' => '',
        //     'note' => '',
        //     'name' => '',
        //     'mobileNumber' => '',
        //     'alternateNumber' => '',
        //     'emailId' => '',
        //     'document' => '',
        //     'reference' => '',
        //     'head' => '',
        //     'priority' => '',
        //     'created_by' => 'required',
        // ]);
        $Validator = Validator::make($request->all(), [
            'developmentWorkId' => '',
            'proposedAmount' => '',
            'sanctionedAmount' => '',
            'workStartDate' => '',
            'tentiveFinishDate' => '',
            'workStatus' => '',
            'actualFinishDate' => '',
            'assemblyId' => '',
            'cityType' => '',
            'gaonId' => '',
            'talukaPanchayatId' => '',
            'zillaParishadId' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'note' => '',
            'name' => '',
            'mobileNumber' => '',
            'alternateNumber' => '',
            'emailId' => '',
            'document' => '',
            'reference' => '',
            'head' => '',
            'priority' => '',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $DevelopmentWorkDetails = DevelopmentWorkDetails::create(array_merge(
        //     $Validator->validated()
        // ));
        
        
        
          $DevelopmentWorkDetails = new DevelopmentWorkDetails();
        $DevelopmentWorkDetails->developmentWorkId = $request->developmentWorkId;
        $DevelopmentWorkDetails->proposedAmount = $request->proposedAmount;
        $DevelopmentWorkDetails->sanctionedAmount = $request->sanctionedAmount;
        $DevelopmentWorkDetails->workStartDate = $request->workStartDate;
        $DevelopmentWorkDetails->tentiveFinishDate = $request->tentiveFinishDate;
        $DevelopmentWorkDetails->workStatus = $request->workStatus;
        $DevelopmentWorkDetails->actualFinishDate = $request->actualFinishDate;
        $DevelopmentWorkDetails->assemblyId = $request->assemblyId;
        $DevelopmentWorkDetails->cityType = $request->cityType;
        $DevelopmentWorkDetails->gaonId = $request->gaonId;
        $DevelopmentWorkDetails->talukaPanchayatId = $request->talukaPanchayatId;
        $DevelopmentWorkDetails->zillaParishadId = $request->zillaParishadId;
        $DevelopmentWorkDetails->wardId = $request->wardId;
        $DevelopmentWorkDetails->wardAreaId = $request->wardAreaId;
        $DevelopmentWorkDetails->note = $request->note;
        $DevelopmentWorkDetails->name = $request->name;
        $DevelopmentWorkDetails->mobileNumber = $request->mobileNumber;
        $DevelopmentWorkDetails->alternateNumber = $request->alternateNumber;
        $DevelopmentWorkDetails->emailId = $request->emailId;
        $DevelopmentWorkDetails->reference = $request->reference;
        $DevelopmentWorkDetails->head = $request->head;
        $DevelopmentWorkDetails->priority = $request->priority;
        $DevelopmentWorkDetails->created_by = $request->userId;
        $DevelopmentWorkDetails->save();

        // if ($request->hasfile('document')) {
        //     $i = 0;
        //     foreach ($request->file('document') as $file) {
        //         $newfile = strstr($request->file('document')->getClientOriginalName(), '.', true) . '_' . date('YmdHis') . $i . '.' . $file->getClientOriginalExtension();
        //         $file->move(public_path('/DevelopmentWorkDetailsDocument'), $newfile);
        //         $DevelopmentWorkDetailsDocument = new Images();
        //         $DevelopmentWorkDetailsDocument->documentName = $newfile;
        //         $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
        //         $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
        //         $DevelopmentWorkDetailsDocument->save();
        //         $i++;
        //     }
        // }

        // if ($req->hasFile('document') && $req->file('document')->isValid()) {
            // foreach ($request->document as $document) {
                // $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                // $document = $request->document;
                // $fileName = $req->file('document');
                // $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                // $document->move(public_path('/DevelopmentWorkDetailsDocument'), $new_name);
                // $DevelopmentWorkDetailsDocument = new Images();
                // $DevelopmentWorkDetailsDocument->documentName = $new_name;
                // $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
                // $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
                // $DevelopmentWorkDetailsDocument->save();
            // }
        // }
        // if ($request->hasFile('documentName') && $request->file('documentName')->isValid()) {
        //     $fileName = $request->file('documentName');
        //     $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
        //     $name = pathinfo($documentName, PATHINFO_FILENAME);
        //     // $name = str_replace(' ', '_', $fileName);
        //     $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
        //     $fileName->move(public_path('/DevelopmentWorkDetailsDocument'), $new_name);
        //     $image = new Images;
        //     $image->documentName = $new_name;
        //     $image->documentType = 'DevelopmentWorkDetails';
        //     $image->typeId = $DevelopmentWorkDetails->id;
        //     $image->isActive = 1;
        //     $image->save();
        // }
        $DevelopmentWorkDetailsDocument = '';
        if ($request->file('documentName') && $request->hasFile('documentName') && $request->file('documentName')->isValid()) {
            $document = $request->documentName;
            $new_name = strstr($request->file('documentName')->getClientOriginalName(), '.', true)  . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/DevelopmentWorkDetailsDocument'), $new_name);
            $DevelopmentWorkDetailsDocument = new Images;
            $DevelopmentWorkDetailsDocument->documentName = $new_name;
            $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
            $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
            $DevelopmentWorkDetailsDocument->save();
        }
        // else {
        //         $image = new Images;
        //         $image->documentName = NULL;
        //         $image->documentType = 'DevelopmentWorkDetails';
        //         $image->typeId = $DevelopmentWorkDetails->id;
        //         $image->isActive = 1;
        //         $image->save();
        //     }

        if ($DevelopmentWorkDetails) {
            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWorkDetails,
                'image'=> $DevelopmentWorkDetailsDocument ? $DevelopmentWorkDetailsDocument : null,
                'message' => 'Development Work Details Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Development Work Details Not Added',
            ]);
        }
    }

    // public function store(Request $request)
    // {
    //     $Validator = Validator::make($request->all(), [
    //         'developmentWorkId' => 'required',
    //         'proposedAmount' => 'required',
    //         'sanctionedAmount' => 'required',
    //         'workStartDate' => 'required',
    //         'tentiveFinishDate' => 'required',
    //         'workStatus' => 'required',
    //         'actualFinishDate' => 'required',
    //         'assemblyId' => 'required',
    //         'cityType' => 'required',
    //         'gaonId' => '',
    //         'talukaPanchayatId' => '',
    //         'zillaParishadId' => '',
    //         'wardId' => '',
    //         'wardAreaId' => '',
    //         'note' => '',
    //         'name' => 'required',
    //         'mobileNumber' => 'required',
    //         'alternateNumber' => '',
    //         'emailId' => '',
    //         'documentName' => '',
    //         'reference' => '',
    //         'head' => '',
    //         'priority' => '',
    //         'created_by' => '',
    //     ]);
    //     if ($Validator->fails()) {
    //         return response()->json($Validator->errors()->tojson(), 400);
    //     }
    //     $DevelopmentWorkDetails = DevelopmentWorkDetails::create(array_merge(
    //         $Validator->validated()
    //     ));

    //     if ($request->hasFile('documentName') && $request->file('documentName')->isValid()) {
    //         $fileName = $request->file('documentName');
    //         $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
    //         $name = pathinfo($documentName, PATHINFO_FILENAME);
    //         $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
    //         $path = $fileName->move(public_path('/DevelopmentWorkDetailsDocument'), $new_name);
    //         $image = new Images;
    //         $image->documentName = $new_name;
    //         $image->documentType = 'DevelopmentWorkDetails';
    //         $image->typeId = $DevelopmentWorkDetails->id;
    //         $image->isActive = 1;
    //         $image->save();
    //     } else {
    //         $image->documentName = null;
    //         $image->documentType = 'DevelopmentWorkDetails';
    //         $image->typeId = $DevelopmentWorkDetails->id;
    //         $image->isActive = 1;
    //         $image->save();
    //     }

    //     // if ($request->hasfile('document')) {
    //     //     $i = 0;
    //     //     foreach ($request->file('document') as $file) {
    //     //         $newfile = strstr($request->file('document')->getClientOriginalName(), '.', true) . '_' . date('YmdHis') . $i . '.' . $file->getClientOriginalExtension();
    //     //         $file->move(public_path('/DevelopmentWorkDetailsDocument'), $newfile);
    //     //         $DevelopmentWorkDetailsDocument = new Images();
    //     //         $DevelopmentWorkDetailsDocument->documentName = $newfile;
    //     //         $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
    //     //         $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
    //     //         $DevelopmentWorkDetailsDocument->save();
    //     //         $i++;
    //     //     }
    //     // }

    //     // if ($req->hasFile('document') && $req->file('document')->isValid()) {
    //     // foreach ($request->document as $document) {
    //     // $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
    //     // $document = $request->document;
    //     // $fileName = $req->file('document');
    //     // $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
    //     // $document->move(public_path('/DevelopmentWorkDetailsDocument'), $new_name);
    //     // $DevelopmentWorkDetailsDocument = new Images();
    //     // $DevelopmentWorkDetailsDocument->documentName = $new_name;
    //     // $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
    //     // $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
    //     // $DevelopmentWorkDetailsDocument->save();
    //     // }
    //     // }

    //     if ($DevelopmentWorkDetails) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $DevelopmentWorkDetails,
    //             'image' => $image,
    //             'message' => 'Development Work Details Added Sucecssfully',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 400,
    //             'data' => [],
    //             'message' => 'Development Work Details Not Added',
    //         ]);
    //     }
    // }

    // View All DevelopmentWorkDetails
  /*  public function index($gaonId =null, $wardId=null)
    {
    

        $data = DB::table('development_work_details')
    ->select(
        'development_work_details.id as developmentWorkDetailsId',
        'development_work_details.developmentWorkId',
        'development_work.developmentWorkName',
        'development_work_details.proposedAmount',
        'development_work_details.sanctionedAmount',
        'development_work_details.workStartDate',
        'development_work_details.tentiveFinishDate',
        'development_work_details.workStatus',
        'development_work_details.actualFinishDate',
        'development_work_details.assemblyId',
        'assembly.assemblyName',
        'development_work_details.cityType',
        'development_work_details.gaonId',
        'gaon.gaonName',
        'development_work_details.talukaPanchayatId',
        'taluka_panchayats.talukaPanchayatName',
        'development_work_details.zillaParishadId',
        'zilla_parishads.zillaParishadName',
        'development_work_details.wardId',
        'ward.wardName',
        'development_work_details.wardAreaId',
        'wardArea.wardAreaName',
        'development_work_details.note',
        'development_work_details.name',
        'development_work_details.mobileNumber',
        'development_work_details.alternateNumber',
        'development_work_details.emailId',
        'development_work_details.reference',
        'development_work_details.head',
        'development_work_details.priority',
        'development_work_details.created_by',
        'citizens.fname',
        'citizens.mname',
        'citizens.lname',
        'citizens.email',
        'citizens.gender',
        'citizens.number',
        'citizens.altNumber',
        'development_work_details.updated_by'
    )
    ->leftJoin('development_work', 'development_work_details.developmentWorkId', '=', 'development_work.id')
    ->leftJoin('assembly', 'development_work_details.assemblyId', '=', 'assembly.id')
    ->leftJoin('gaon', 'development_work_details.gaonId', '=', 'gaon.id')
    ->leftJoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', '=', 'taluka_panchayats.id')
    ->leftJoin('zilla_parishads', 'development_work_details.zillaParishadId', '=', 'zilla_parishads.id')
    ->leftJoin('ward', 'development_work_details.wardId', '=', 'ward.id')
    ->leftJoin('wardArea', 'development_work_details.wardAreaId', '=', 'wardArea.id')
    ->leftJoin('citizens', 'development_work_details.created_by', '=', 'citizens.id')
    ->where('development_work_details.gaonId', $gaonId)
    ->orWhere('development_work_details.wardId', $wardId)
    // ->orderBy('development_work_details.actualFinishDate', 'DESC') // Uncomment if needed
    ->get();

        return $this->sendResponse($data);
    } */
    
     public function index($gaonId =null, $wardId=null)
    {
    

        $data = DB::table('development_work_details')
    ->select(
        'development_work_details.id as developmentWorkDetailsId',
        'development_work_details.developmentWorkId',
        'development_work.developmentWorkName',
        'development_work_details.proposedAmount',
        'development_work_details.sanctionedAmount',
        'development_work_details.workStartDate',
        'development_work_details.tentiveFinishDate',
        'development_work_details.workStatus',
        'development_work_details.actualFinishDate',
        'development_work_details.assemblyId',
        'assembly.assemblyName',
        'development_work_details.cityType',
        'development_work_details.gaonId',
        'gaon.gaonName',
        'development_work_details.talukaPanchayatId',
        'taluka_panchayats.talukaPanchayatName',
        'development_work_details.zillaParishadId',
        'zilla_parishads.zillaParishadName',
        'development_work_details.wardId',
        'ward.wardName',
        'development_work_details.wardAreaId',
        'wardArea.wardAreaName',
        'development_work_details.note',
        'development_work_details.name',
        'development_work_details.mobileNumber',
        'development_work_details.alternateNumber',
        'development_work_details.emailId',
        'development_work_details.reference',
        'development_work_details.head',
        'development_work_details.priority',
        'development_work_details.created_by',
        'citizens.fname',
        'citizens.mname',
        'citizens.lname',
        'citizens.email',
        'citizens.gender',
        'citizens.number',
        'citizens.altNumber',
        'development_work_details.updated_by'
    )
    ->leftJoin('development_work', 'development_work_details.developmentWorkId', '=', 'development_work.id')
    ->leftJoin('assembly', 'development_work_details.assemblyId', '=', 'assembly.id')
    ->leftJoin('gaon', 'development_work_details.gaonId', '=', 'gaon.id')
    ->leftJoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', '=', 'taluka_panchayats.id')
    ->leftJoin('zilla_parishads', 'development_work_details.zillaParishadId', '=', 'zilla_parishads.id')
    ->leftJoin('ward', 'development_work_details.wardId', '=', 'ward.id')
    ->leftJoin('wardArea', 'development_work_details.wardAreaId', '=', 'wardArea.id')
    ->leftJoin('citizens', 'development_work_details.created_by', '=', 'citizens.id')
    //->where('development_work_details.gaonId', $gaonId)
   // ->orWhere('development_work_details.wardId', $wardId)
   
   
   ->when($gaonId, function ($query) use ($gaonId) {
                $query->where('development_work_details.gaonId', $gaonId);
            })
            ->when($wardId, function ($query) use ($wardId) {
                $query->orWhere('development_work_details.wardId', $wardId);
            })
   
   
   
    ->get();

    
     if (count($data)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Data Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Found',
            ]);
        }

       
    }
    
    
    
    

    //View Ward By Id
    public function show($developmentWorkDetailsId)
    {
        $DevelopmentWorkDetails = DevelopmentWorkDetails::select('development_work_details.id as developmentWorkDetailsId', 'development_work_details.developmentWorkId', 'development_work.developmentWorkName', 'development_work_details.proposedAmount', 'development_work_details.sanctionedAmount', 'development_work_details.workStartDate', 'development_work_details.tentiveFinishDate', 'development_work_details.workStatus', 'development_work_details.actualFinishDate', 'development_work_details.assemblyId', 'assembly.assemblyName', 'development_work_details.cityType', 'development_work_details.gaonId', 'gaon.gaonName', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'development_work_details.zillaParishadId', 'zilla_parishads.zillaParishadName', 'development_work_details.wardId', 'ward.wardName', 'development_work_details.wardAreaId', 'wardArea.wardAreaName', 'development_work_details.note', 'development_work_details.name', 'development_work_details.mobileNumber', 'development_work_details.alternateNumber', 'development_work_details.emailId', 'development_work_details.reference', 'development_work_details.head', 'development_work_details.priority', 'development_work_details.created_by', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'development_work_details.updated_by')
            ->leftjoin('development_work', 'development_work_details.developmentWorkId', 'development_work.id')
            ->leftjoin('assembly', 'development_work_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'development_work_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'development_work_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'development_work_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'development_work_details.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens', 'development_work_details.created_by', 'citizens.id')
            ->where('development_work_details.id', $developmentWorkDetailsId)->get();

        // Document
        $path = 'https://mlaapi.orisunlifescience.com/public/DevelopmentWorkDetailsDocument/';
        $Documents = Images::select('images.typeId as developmentWorkDetailsId', 'images.documentName')->where('images.typeId', $developmentWorkDetailsId)->where('images.documentType', 'DevelopmentWorkDetails')->get();
        if (count($Documents) != 0) {
            foreach ($Documents as $Document) {
                $res = [
                    'developmentWorkDetailsId' => $Document->developmentWorkDetailsId,
                    'documentName' => $path . $Document->documentName,
                    'fileName'=> $Document->documentName
                ];
                $result[] = $res;
            }
        } else {
            $result = null;
        }

        if (count($DevelopmentWorkDetails) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWorkDetails[0],
                'document' => $result,
                'message' => 'Development Work Details Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Details Not Found',
            ]);
        }
    }

    //Update DevelopmentWorkDetails
    public function update(Request $request, $developmentWorkDetailsId)
    {
        $request->validate([
            'developmentWorkId' => 'required',
            'proposedAmount' => 'required',
            'sanctionedAmount' => 'required',
            'workStartDate' => 'required',
            'tentiveFinishDate' => '',
            'workStatus' => 'required',
            'actualFinishDate' => 'required',
            'assemblyId' => 'required',
            'cityType' => 'required',
            'gaonId' => '',
            'talukaPanchayatId' => '',
            'zillaParishadId' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'note' => '',
            'name' => 'required',
            'mobileNumber' => 'required',
            'alternateNumber' => '',
            'emailId' => '',
            'document' => '',
            'reference' => '',
            'head' => '',
            'priority' => '',
            'updated_by' => '',
        ]);

        $DevelopmentWorkDetails = DevelopmentWorkDetails::find($developmentWorkDetailsId);
        if ($DevelopmentWorkDetails) {
            $DevelopmentWorkDetails->developmentWorkId = $request->developmentWorkId;
            $DevelopmentWorkDetails->proposedAmount = $request->proposedAmount;
            $DevelopmentWorkDetails->sanctionedAmount = $request->sanctionedAmount;
            $DevelopmentWorkDetails->workStartDate = $request->workStartDate;
            $DevelopmentWorkDetails->tentiveFinishDate = $request->tentiveFinishDate;
            $DevelopmentWorkDetails->workStatus = $request->workStatus;
            $DevelopmentWorkDetails->actualFinishDate = $request->actualFinishDate;
            $DevelopmentWorkDetails->assemblyId = $request->assemblyId;
            $DevelopmentWorkDetails->cityType = $request->cityType;
            $DevelopmentWorkDetails->gaonId = $request->gaonId;
            $DevelopmentWorkDetails->talukaPanchayatId = $request->talukaPanchayatId;
            $DevelopmentWorkDetails->zillaParishadId = $request->zillaParishadId;
            $DevelopmentWorkDetails->note = $request->note;
            $DevelopmentWorkDetails->name = $request->name;
            $DevelopmentWorkDetails->mobileNumber = $request->mobileNumber;
            $DevelopmentWorkDetails->alternateNumber = $request->alternateNumber;
            $DevelopmentWorkDetails->emailId = $request->emailId;
            $DevelopmentWorkDetails->reference = $request->reference;
            $DevelopmentWorkDetails->head = $request->head;
            $DevelopmentWorkDetails->priority = $request->priority;
            $DevelopmentWorkDetails->updated_by = $request->updated_by;
            $DevelopmentWorkDetails->update();
            // if ($request->hasfile('document')) {
            //     $i = 0;
            //     foreach ($request->file('document') as $file) {
            //         $newfile = strstr($request->file('document')->getClientOriginalName(), '.', true) . '_' . date('YmdHis') . $i . '.' . $file->getClientOriginalExtension();
            //         $file->move(public_path('/DevelopmentWorkDetailsDocument'), $newfile);
            //         $DevelopmentWorkDetailsDocument = new Images();
            //         $DevelopmentWorkDetailsDocument->documentName = $newfile;
            //         $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
            //         $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
            //         $DevelopmentWorkDetailsDocument->save();
            //         $i++;
            //     }
            // }
            if ($request->hasFile('document') && $request->file('document')->isValid()) {
                $document = $request->document;
                $new_name = strstr($request->file('document')->getClientOriginalName(), '.', true)  . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('/DevelopmentWorkDetailsDocument'), $new_name);
                $DevelopmentWorkDetailsDocument = new Images;
                $DevelopmentWorkDetailsDocument->documentName = $new_name;
                $DevelopmentWorkDetailsDocument->documentType = 'DevelopmentWorkDetails';
                $DevelopmentWorkDetailsDocument->typeId = $DevelopmentWorkDetails->id;
                $DevelopmentWorkDetailsDocument->save();
            }

            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWorkDetails,
                'message' => 'Development Work Details Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Details Not Found',
            ]);
        }
    }

    public function updateStatus(Request $request, $developmentWorkDetailsId)
    {
        $request->validate([
            'workStatus' => 'required',
            'userId' => 'required',
        ]);

        $DevelopmentWorkDetails = DevelopmentWorkDetails::find($developmentWorkDetailsId);
        if ($DevelopmentWorkDetails) {
            $DevelopmentWorkDetails->workStatus = $request->workStatus;
            $DevelopmentWorkDetails->updated_by = $request->userId;
            $DevelopmentWorkDetails->update();
            if ($request->has('document')) {
                $document = $request->file('document');
                $newName = 'DevelopmentWorkDetailsDocument' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('/DevelopmentWorkDetailsDocument'), $newName);
                $image = new Images();
                $image->documentName = $newName;
                $image->documentType = 'DevelopmentWorkDetails';
                $image->typeId = $DevelopmentWorkDetails->id;
                $image->save();
            }

            return response()->json([
                'code' => 200,
                'data' => $DevelopmentWorkDetails,
                'message' => 'Development Work Details Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Details Not Found',
            ]);
        }
    }

    //Delete DevelopmentWorkDetails
    public function destroy($developmentWorkDetailsId)
    {
        $DevelopmentWorkDetails = DevelopmentWorkDetails::find($developmentWorkDetailsId);

        if ($DevelopmentWorkDetails) {
            $DevelopmentWorkDetails->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Development Work Details deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Details Not Found',
            ]);
        }
    }

    // public function viewWorkDetailByPagination($pageNo,$pageSize, $status = null)
    // {
    //   // $count = DevelopmentWorkDetails::count();
    //   // $limit = 25;
    //   // $totalPage = ceil($count / $limit);
    //     $DevelopmentWorkDetails = DevelopmentWorkDetails::select('development_work_details.id as developmentWorkDetailsId', 'development_work_details.developmentWorkId', 'development_work.developmentWorkName', 'development_work_details.proposedAmount', 'development_work_details.sanctionedAmount', 'development_work_details.workStartDate', 'development_work_details.tentiveFinishDate', 'development_work_details.workStatus', 'development_work_details.actualFinishDate', 'development_work_details.assemblyId', 'assembly.assemblyName', 'development_work_details.cityType', 'development_work_details.gaonId', 'gaon.gaonName', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'development_work_details.zillaParishadId', 'zilla_parishads.zillaParishadName', 'development_work_details.wardId', 'ward.wardName', 'development_work_details.wardAreaId', 'wardArea.wardAreaName', 'development_work_details.note', 'development_work_details.name', 'development_work_details.mobileNumber', 'development_work_details.alternateNumber', 'development_work_details.emailId', 'development_work_details.reference', 'development_work_details.head', 'development_work_details.priority', 'development_work_details.created_by', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'development_work_details.updated_by')
    //         ->leftjoin('development_work', 'development_work_details.developmentWorkId', 'development_work.id')
    //         ->leftjoin('assembly', 'development_work_details.assemblyId', 'assembly.id')
    //         ->leftjoin('gaon', 'development_work_details.gaonId', 'gaon.id')
    //         ->leftjoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.id')
    //         ->leftjoin('zilla_parishads', 'development_work_details.zillaParishadId', 'zilla_parishads.id')
    //         ->leftjoin('ward', 'development_work_details.wardId', 'ward.id')
    //         ->leftjoin('wardArea', 'development_work_details.wardAreaId', 'wardArea.id')
    //         ->leftjoin('citizens', 'development_work_details.created_by', 'citizens.id');

    //         if($status){
    //             $DevelopmentWorkDetails->where('development_work_details.workStatus',$status);
    //         }
    //     $DevelopmentWorkDetails->orderBy('development_work_details.id', 'desc')
    //         ->selectRaw('ROW_NUMBER() OVER (ORDER BY development_work_details.id desc) AS RowNum');

    //     $count = $DevelopmentWorkDetails->count();
    //   // $limit = 25;
    //     $totalPage = ceil($count / $pageSize);

    //     $subquery = DB::table(DB::raw("({$DevelopmentWorkDetails->toSql()}) as sub"))
    //         ->mergeBindings($DevelopmentWorkDetails->getQuery())
    //         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);
    //     $DevelopmentWorkDetails = $subquery->get();
    //     if (count($DevelopmentWorkDetails) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $DevelopmentWorkDetails,
    //             'currentPage'=>$pageNo,
    //             'count' => $count,
    //             'totalPage' => $totalPage,
    //             'message' => 'Development Work Details Fetched Sucecssfully',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Development Work Details Not Found',
    //         ]);
    //     }
    // }
    public function viewWorkDetailByPagination($pageNo,$pageSize, $status = null)
    {
      // $count = DevelopmentWorkDetails::count();
      // $limit = 25;
      // $totalPage = ceil($count / $limit);
        $DevelopmentWorkDetails = DevelopmentWorkDetails::select('development_work_details.id as developmentWorkDetailsId', 'development_work_details.developmentWorkId', 'development_work.developmentWorkName', 'development_work_details.proposedAmount', 'development_work_details.sanctionedAmount', 'development_work_details.workStartDate', 'development_work_details.tentiveFinishDate', 'development_work_details.workStatus', 'development_work_details.actualFinishDate', 'development_work_details.assemblyId', 'assembly.assemblyName', 'development_work_details.cityType', 'development_work_details.gaonId', 'gaon.gaonName', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'development_work_details.zillaParishadId', 'zilla_parishads.zillaParishadName', 'development_work_details.wardId', 'ward.wardName', 'development_work_details.wardAreaId', 'wardArea.wardAreaName', 'development_work_details.note', 'development_work_details.name', 'development_work_details.mobileNumber', 'development_work_details.alternateNumber', 'development_work_details.emailId', 'development_work_details.reference', 'development_work_details.head', 'development_work_details.priority', 'development_work_details.created_by', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'development_work_details.updated_by')
            ->leftjoin('development_work', 'development_work_details.developmentWorkId', 'development_work.id')
    ->leftjoin('assembly', 'development_work_details.assemblyId', 'assembly.id')
    ->leftjoin('gaon', 'development_work_details.gaonId', 'gaon.id')
    ->leftjoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.id')
    ->leftjoin('zilla_parishads', 'development_work_details.zillaParishadId', 'zilla_parishads.id')
    ->leftjoin('ward', 'development_work_details.wardId', 'ward.id')
    ->leftjoin('wardArea', 'development_work_details.wardAreaId', 'wardArea.id')
    ->leftjoin('citizens', 'development_work_details.created_by', 'citizens.id')
    ->when($status, function ($query, $status) {
        return $query->where('development_work_details.workStatus', $status);
    })
    ->orderBy('development_work_details.id', 'desc');

    $count = $DevelopmentWorkDetails->count();
    $totalPage = ceil($count / $pageSize);

    $DevelopmentWorkDetails = $DevelopmentWorkDetails
        ->offset(($pageNo - 1) * $pageSize)
        ->limit($pageSize)
        ->get();

    if ($DevelopmentWorkDetails->isNotEmpty()) {
        return response()->json([
            'code' => 200,
            'data' => $DevelopmentWorkDetails,
            'currentPage' => $pageNo,
            'count' => $count,
            'totalPage' => $totalPage,
            'message' => 'Development Work Details Fetched Successfully',
        ]);
    } else {
        return response()->json([
            'code' => 404,
            'data' => [],
            'message' => 'Development Work Details Not Found',
        ]);
    }
    }

    // search by token or status
    // public function searchDevelopmentWorkDetailsByTokenOrStatus($token = null, $status = null)
    // public function searchDevelopmentWorkDetailsByTokenOrStatus($status = null)
    // {
    //     $query = DevelopmentWorkDetails::select('development_work_details.id as developmentWorkDetailsId', 'development_work_details.developmentWorkId', 'development_work.developmentWorkName', 'development_work_details.proposedAmount', 'development_work_details.sanctionedAmount', 'development_work_details.workStartDate', 'development_work_details.tentiveFinishDate', 'development_work_details.workStatus', 'development_work_details.actualFinishDate', 'development_work_details.assemblyId', 'assembly.assemblyName', 'development_work_details.cityType', 'development_work_details.gaonId', 'gaon.gaonName', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'development_work_details.zillaParishadId', 'zilla_parishads.zillaParishadName', 'development_work_details.wardId', 'ward.wardName', 'development_work_details.wardAreaId', 'wardArea.wardAreaName', 'development_work_details.note', 'development_work_details.name', 'development_work_details.mobileNumber', 'development_work_details.alternateNumber', 'development_work_details.emailId', 'development_work_details.reference', 'development_work_details.head', 'development_work_details.priority', 'development_work_details.created_by', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'development_work_details.updated_by')
    //         ->leftjoin('development_work', 'development_work_details.developmentWorkId', 'development_work.id')
    //         ->leftjoin('assembly', 'development_work_details.assemblyId', 'assembly.id')
    //         ->leftjoin('gaon', 'development_work_details.gaonId', 'gaon.id')
    //         ->leftjoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.id')
    //         ->leftjoin('zilla_parishads', 'development_work_details.zillaParishadId', 'zilla_parishads.id')
    //         ->leftjoin('ward', 'development_work_details.wardId', 'ward.id')
    //         ->leftjoin('wardArea', 'development_work_details.wardAreaId', 'wardArea.id')
    //         ->leftjoin('citizens', 'development_work_details.created_by', 'citizens.id');
    //     // if ($token) {
    //     //     $query->where('development_work_details.token', $token);
    //     // }

    //     if ($status) {
    //         $data = $query->where('development_work_details.status', $status);
    //     }

    //     // $data = $query->orderBy('development_work_details.id', 'desc')->get();
    //     // return $this->sendResponse($data);
    //      return response()->json([
    //             'code' => 200,
    //             'data' => $data,
    //             'message' => 'Development Work Details Fetched Sucecssfully',
    //         ]);
    // }

    public function searchDevelopmentWorkDetailsByTokenOrStatus($status){
        $data = DB::table('development_work_details')
            ->select(
                'development_work_details.id as developmentWorkDetailsId',
                'development_work_details.developmentWorkId',
                'development_work.developmentWorkName',
                'development_work_details.proposedAmount',
                'development_work_details.sanctionedAmount',
                'development_work_details.workStartDate',
                'development_work_details.tentiveFinishDate',
                'development_work_details.workStatus',
                'development_work_details.actualFinishDate',
                'development_work_details.assemblyId',
                'assembly.assemblyName',
                'development_work_details.cityType',
                'development_work_details.gaonId',
                'gaon.gaonName',
                'development_work_details.talukaPanchayatId',
                'taluka_panchayats.talukaPanchayatName',
                'development_work_details.zillaParishadId',
                'zilla_parishads.zillaParishadName',
                'development_work_details.wardId',
                'ward.wardName',
                'development_work_details.wardAreaId',
                'wardArea.wardAreaName',
                'development_work_details.note',
                'development_work_details.name',
                'development_work_details.mobileNumber',
                'development_work_details.alternateNumber',
                'development_work_details.emailId',
                'development_work_details.reference',
                'development_work_details.head',
                'development_work_details.priority',
                'development_work_details.created_by',
                'citizens.fname',
                'citizens.mname',
                'citizens.lname',
                'citizens.email',
                'citizens.gender',
                'citizens.number',
                'citizens.altNumber',
                'development_work_details.updated_by'
            )
            ->leftJoin('development_work', 'development_work_details.developmentWorkId', '=', 'development_work.id')
            ->leftJoin('assembly', 'development_work_details.assemblyId', '=', 'assembly.id')
            ->leftJoin('gaon', 'development_work_details.gaonId', '=', 'gaon.id')
            ->leftJoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', '=', 'taluka_panchayats.id')
            ->leftJoin('zilla_parishads', 'development_work_details.zillaParishadId', '=', 'zilla_parishads.id')
            ->leftJoin('ward', 'development_work_details.wardId', '=', 'ward.id')
            ->leftJoin('wardArea', 'development_work_details.wardAreaId', '=', 'wardArea.id')
            ->leftJoin('citizens', 'development_work_details.created_by', '=', 'citizens.id')
            ->where('development_work_details.workStatus', 'LIKE', '%' . $status .'%')
            ->get();
        return $this->sendResponse($data);
    }

    public function viewWorkDetailByFilter($workStatus = null, $developmentWorkId = null, $assemblyId = null, $cityType = null, $wardId = null, $wardAreaId = null, $gaonId = null, $talukaPanchayatId = null, $zillaParishadId = null, $fromDate = null, $toDate = null, $tentiveFromDate = null, $tentiveToDate = null)
    {
        $query = DevelopmentWorkDetails::select('development_work_details.id as developmentWorkDetailsId', 'development_work_details.developmentWorkId', 'development_work.developmentWorkName', 'development_work_details.proposedAmount', 'development_work_details.sanctionedAmount', 'development_work_details.workStartDate', 'development_work_details.tentiveFinishDate', 'development_work_details.workStatus', 'development_work_details.actualFinishDate', 'development_work_details.assemblyId', 'assembly.assemblyName', 'development_work_details.cityType', 'development_work_details.gaonId', 'gaon.gaonName', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'development_work_details.zillaParishadId', 'zilla_parishads.zillaParishadName', 'development_work_details.wardId', 'ward.wardName', 'development_work_details.wardAreaId', 'wardArea.wardAreaName', 'development_work_details.note', 'development_work_details.name', 'development_work_details.mobileNumber', 'development_work_details.alternateNumber', 'development_work_details.emailId', 'development_work_details.reference', 'development_work_details.head', 'development_work_details.priority', 'development_work_details.created_by', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'development_work_details.updated_by')
            ->leftjoin('development_work', 'development_work_details.developmentWorkId', 'development_work.id')
            ->leftjoin('assembly', 'development_work_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'development_work_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'development_work_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'development_work_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'development_work_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'development_work_details.wardAreaId', 'wardArea.id')
            ->leftjoin('citizens', 'development_work_details.created_by', 'citizens.id');

        if ($workStatus) {
            $query->where('development_work_details.workStatus', $workStatus);
        }

        if ($developmentWorkId) {
            $query->where('development_work_details.developmentWorkId', $developmentWorkId);
        }

        if ($assemblyId) {
            $query->where('development_work_details.assemblyId', $assemblyId);
        }

        if ($cityType) {
            $query->where('development_work_details.cityType', $cityType);
        }

        if ($wardId) {
            $query->where('development_work_details.wardId', $wardId);
        }

        if ($wardAreaId) {
            $query->where('development_work_details.wardAreaId', $wardAreaId);
        }

        if ($gaonId) {
            $query->where('development_work_details.gaonId', $gaonId);
        }

        if ($talukaPanchayatId) {
            $query->where('development_work_details.talukaPanchayatId', $talukaPanchayatId);
        }

        if ($zillaParishadId) {
            $query->where('development_work_details.zillaParishadId', $zillaParishadId);
        }

        if ($fromDate && $toDate) {
            $query->where(function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('development_work_details.workStartDate', [$fromDate, $toDate])
                    ->orWhereBetween('development_work_details.actualFinishDate', [$fromDate, $toDate]);
            });
        }

        if ($tentiveFromDate && $tentiveToDate) {
            $query->whereBetween('development_work_details.tentiveFinishDate', [$tentiveFromDate, $tentiveToDate]);
        }

        $query->orderBy('development_work_details.id', 'desc');

        $count = $query->count();
        $subquery = DB::table(DB::raw("({$query->toSql()}) as sub"))
            ->mergeBindings($query->getQuery());
        $result = $subquery->get();

        if ($result->isNotEmpty()) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'count' => $count,
                'message' => 'Development Work Details Fetched Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Details Not Found',
            ]);
        }
    }
    public function sendResponse($data)
    {
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Development Work Details Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Development Work Details Not Found',
            ]);
        }
    }
}
