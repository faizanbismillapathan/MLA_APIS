<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ComplaintDetails;
use App\Models\Images;
use App\Models\ComplaintAssignedAdhikari;
use App\Models\ComplaintAssignedKaryakarta;
use Illuminate\Support\Facades\DB;

class ComplaintDetailsController extends Controller
{
    //Add ComplaintDetails
    public function store(Request $request)
    {
        $request->validate([
            'complainerId' => 'required',
            'issue' => 'required',
            'actualComplaintDate' => 'required',
            'complaintCategoryId' => 'required',
            'complaintSubCategoryId' => 'required',
            'complaintDueDate' => 'required',
            'address' => 'required',
            'pincode' => '',
            'assemblyId' => 'required',
            'cityType' => 'required',
            'gaonId' => '',
            'talukaPanchayatId' => '',
            'zillaParishadId' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'followUp' => 'required',
            'status' => '',
            'document' => '',
            'karyakartaId' => '',
            'adhikariId' => '',
            'created_by' => '',
        ]);

        // Add ComplaintDetails Data
        $ComplaintDetails = new ComplaintDetails();
        $ComplaintDetails->complainerId = $request->complainerId;
        $ComplaintDetails->issue = $request->issue;
        $ComplaintDetails->actualComplaintDate = $request->actualComplaintDate;
        $ComplaintDetails->complaintCategoryId = $request->complaintCategoryId;
        $ComplaintDetails->complaintSubCategoryId = $request->complaintSubCategoryId;
        $ComplaintDetails->complaintDueDate = $request->complaintDueDate;
        $ComplaintDetails->address = $request->address;
        $ComplaintDetails->pincode = $request->pincode;
        $ComplaintDetails->assemblyId = $request->assemblyId;
        $ComplaintDetails->cityType = $request->cityType;
        $ComplaintDetails->gaonId = $request->gaonId;
        $ComplaintDetails->talukaPanchayatId = $request->talukaPanchayatId;
        $ComplaintDetails->zillaParishadId = $request->zillaParishadId;
        $ComplaintDetails->wardId = $request->wardId;
        $ComplaintDetails->wardAreaId = $request->wardAreaId;
        $ComplaintDetails->followUp = $request->followUp;
        $ComplaintDetails->status = $request->status;
        $ComplaintDetails->created_by = $request->created_by;
        $ComplaintDetails->save();

        // Token
        $token = ComplaintDetails::where('complaint_details.id', $ComplaintDetails->id)->update(['complaint_details.token' => 'CPL-' . $ComplaintDetails->id]);

        //  For document
    $image='';
        if ($request->hasFile('documentName') && $request->file('documentName')->isValid()) {
            $fileName = $request->file('documentName');
            $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
            $name = pathinfo($documentName, PATHINFO_FILENAME);
            $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
            $path = $fileName->move(public_path('/ComplaintDetailsDocument'), $new_name);
            $image = new Images;
            $image->documentName = $new_name;
            $image->documentType = 'ComplaintDetails';
            $image->typeId = $ComplaintDetails->id;
            $image->isActive = 1;
            $image->save();
        } 
        // else {
        //     $image->documentName = null;
        //     $image->documentType = 'ComplaintDetails';
        //     $image->typeId = $ComplaintDetails->id;
        //     $image->isActive = 1;
        //     $image->save();
        // }


        // if ($request->document) {
        //     $document = $request->document;
        //     $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
        //     $document->move(public_path('/ComplaintDetailsDocument'), $new_name);

        //     $ComplaintDetailsDocument = new Images();
        //     $ComplaintDetailsDocument->documentName = $new_name;
        //     $ComplaintDetailsDocument->documentType = 'ComplaintDetails';
        //     $ComplaintDetailsDocument->typeId = $ComplaintDetails->id;
        //     $ComplaintDetailsDocument->save();
        // }

        // For Karyakarta
        if ($request->karyakartaId) {
            foreach ($request->karyakartaId as $karyakartaId) {
                $karyakarta = new ComplaintAssignedKaryakarta();
                $karyakarta->complaintDetailsId = $ComplaintDetails->id;
                $karyakarta->karyakartaId = $karyakartaId;
                $karyakarta->save();
            }
        }

        // For Adhikari
        if ($request->adhikariId) {
            foreach ($request->adhikariId as $adhikariId) {
                $adhikari = new ComplaintAssignedAdhikari();
                $adhikari->complaintDetailsId = $ComplaintDetails->id;
                $adhikari->adhikariId = $adhikariId;
                $adhikari->save();
            }
        }
        // [1],[3]
        // [{1,3}]
        if ($ComplaintDetails) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintDetails::where('complaint_details.id', $ComplaintDetails->id)->get(),
                'document' => $image ? $image : null,
                'message' => 'Complaint Details Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Complaint Details Not Added',
            ]);
        }
    } 

// Vipul (trying to save Multi file )
 //Add ComplaintDetails
   /*  public function store(Request $request)
    {
        $request->validate([
            'complainerId' => 'required',
            'issue' => 'required',
            'actualComplaintDate' => 'required',
            'complaintCategoryId' => 'required',
            'complaintSubCategoryId' => 'required',
            'complaintDueDate' => 'required',
            'address' => 'required',
            'pincode' => '',
            'assemblyId' => 'required',
            'cityType' => 'required',
            'gaonId' => '',
            'talukaPanchayatId' => '',
            'zillaParishadId' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'followUp' => 'required',
            'status' => '',
            'document' => '',
            'karyakartaId' => '',
            'adhikariId' => '',
            'created_by' => '',
        ]);

        // Add ComplaintDetails Data
        $ComplaintDetails = new ComplaintDetails();
        $ComplaintDetails->complainerId = $request->complainerId;
        $ComplaintDetails->issue = $request->issue;
        $ComplaintDetails->actualComplaintDate = $request->actualComplaintDate;
        $ComplaintDetails->complaintCategoryId = $request->complaintCategoryId;
        $ComplaintDetails->complaintSubCategoryId = $request->complaintSubCategoryId;
        $ComplaintDetails->complaintDueDate = $request->complaintDueDate;
        $ComplaintDetails->address = $request->address;
        $ComplaintDetails->pincode = $request->pincode;
        $ComplaintDetails->assemblyId = $request->assemblyId;
        $ComplaintDetails->cityType = $request->cityType;
        $ComplaintDetails->gaonId = $request->gaonId;
        $ComplaintDetails->talukaPanchayatId = $request->talukaPanchayatId;
        $ComplaintDetails->zillaParishadId = $request->zillaParishadId;
        $ComplaintDetails->wardId = $request->wardId;
        $ComplaintDetails->wardAreaId = $request->wardAreaId;
        $ComplaintDetails->followUp = $request->followUp;
        $ComplaintDetails->status = $request->status;
        $ComplaintDetails->created_by = $request->created_by;
        $ComplaintDetails->save();

        // Token
        $token = ComplaintDetails::where('complaint_details.id', $ComplaintDetails->id)->update(['complaint_details.token' => 'CPL-' . $ComplaintDetails->id]);

        //  For document

        
             $images = [];



    
    if ($request->hasFile('documentName') && is_array($request->file('documentName'))) {
    foreach ($request->file('documentName') as $file) {
        // Check if the file is valid
        if ($file->isValid()) {
            // Generate a new file name
            $fileName = $file->getClientOriginalName();
            $documentName = str_replace(' ', '_', $fileName);
            $name = pathinfo($documentName, PATHINFO_FILENAME);
            $new_name = $name . date('YmdHis') . '.' . $file->getClientOriginalExtension();

            // Move the file to the specified directory
            $path = $file->move(public_path('/ComplaintDetailsDocument'), $new_name);

            // Create a new Images instance and save to the database
            $image = new Images;
            $image->documentName = $new_name;
            $image->documentType = 'ComplaintDetails';
            // Make sure $ComplaintDetails is initialized before using it here
            $image->typeId = $ComplaintDetails->id;
            $image->isActive = 1;
            $image->save();

            // Add the image to the $images array
            $images[] = $image;
        } 
    }
}
        
        
      

        // For Karyakarta
        if ($request->karyakartaId) {
            foreach ($request->karyakartaId as $karyakartaId) {
                $karyakarta = new ComplaintAssignedKaryakarta();
                $karyakarta->complaintDetailsId = $ComplaintDetails->id;
                $karyakarta->karyakartaId = $karyakartaId;
                $karyakarta->save();
            }
        }

        // For Adhikari
        if ($request->adhikariId) {
            foreach ($request->adhikariId as $adhikariId) {
                $adhikari = new ComplaintAssignedAdhikari();
                $adhikari->complaintDetailsId = $ComplaintDetails->id;
                $adhikari->adhikariId = $adhikariId;
                $adhikari->save();
            }
        }
      
        if ($ComplaintDetails) {
        return response()->json([
            'code' => 200,
            'data' => ComplaintDetails::with('images')->find($ComplaintDetails->id),
            'message' => 'Complaint Details Added Successfully',
        ]);
    } else {
        return response()->json([
            'code' => 400,
            'data' => [],
            'message' => 'Complaint Details Not Added',
        ]);
    }
    }
    */

    // issue,actualComplaintDate,complaintCategoryId,complaintSubCategoryId,complaintDueDate,address,assemblyId,cityType,gaonId,talukaPanchayatId,zillaParishadId,wardId,wardAreaId,followUp,document,karyakartaId,adhikariId

    // View All ComplaintDetails
    public function index()
    {
        $data = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.token', 'complaint_details.complainerId', 'citizens.fname as complainerFname', 'citizens.mname as complainerMname', 'citizens.lname as complainerLname', 'citizens.number as complainerMobileNumber', 'citizens.altNumber as complainerAltNumber', 'tp.talukaPanchayatName as complainertalukaPanchayatName', 'complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.pincode', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status', 'complaint_details.created_by', 'c.fname as createdByFname', 'c.mname as createdByMname', 'c.lname as createdByLname', 'complaint_details.updated_by', 'complaint_details.created_at')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('citizens as c', 'complaint_details.created_by', 'c.id')
            ->leftjoin('taluka_panchayats as tp', 'citizens.talukaPanchayatId', 'tp.id')
            ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
            ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
            ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id')
            ->orderBy('complaint_details.id', 'desc')
            ->get();

        return $this->sendResponse($data);
    }

    //View ComplaintDetails By Id
    public function show($complaintDetailsId)
    {
        $ComplainerDetails = ComplaintDetails::select('c.id', 'c.fname', 'c.number','c.occupation','c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName')
            ->leftjoin('citizens as c', 'complaint_details.complainerId', 'c.id')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->leftjoin('assembly as a', 'c.assemblyId', 'a.id')
            ->leftjoin('zilla_parishads as zp', 'c.zillaParishadId', 'zp.id')
            ->where('complaint_details.id', $complaintDetailsId)
            ->get();

        $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.token', 'complaint_details.complainerId', 'complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.pincode', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status', 'complaint_details.created_by', 'c.fname as createdByFname', 'c.mname as createdByMname', 'c.lname as createdByLname', 'complaint_details.updated_by', 'complaint_details.created_at')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('citizens as c', 'complaint_details.created_by', 'c.id')
            ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
            ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
            ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id')
            ->where('complaint_details.id', $complaintDetailsId)->get();

        // Document
        $Documents = Images::select('images.typeId as complaintDetailsId', 'images.documentName')->where('images.typeId', $complaintDetailsId)->where('images.documentType', 'ComplaintDetails')->get();

        if (count($Documents) != 0) {
            foreach ($Documents as $Document) {
                $res = [
                    'complaintDetailsId' => $Document->complaintDetailsId,
                    'photo' => 'https://mlaapi.orisunlifescience.com/public/ComplaintDetailsDocument/' . $Document->documentName,
                    'fileName' => $Document->documentName
                ];
                $result[] = $res;
            }
        } else {
            $result = null;
        }
        // Karyakarta
        $Karyakarta = ComplaintAssignedKaryakarta::select('complaint_assigned_karyakarta.complaintDetailsId', 'complaint_assigned_karyakarta.karyakartaId', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'citizens.password', 'citizens.role', 'citizens.office', 'citizens.dob', 'citizens.education', 'citizens.occupation', 'citizens.cast', 'citizens.subCast', 'citizens.addNote', 'citizens.photo', 'citizens.aadharNumber', 'citizens.panNumber', 'citizens.voterId', 'citizens.rationCard', 'citizens.assemblyId', 'assembly.assemblyName', 'citizens.cityType', 'citizens.zillaParishadId', 'zilla_parishads.zillaParishadName', 'citizens.talukaPanchayatId', 'taluka_panchayats.talukaPanchayatName', 'citizens.gaonId', 'gaon.gaonName', 'citizens.wardId', 'ward.wardName', 'citizens.wardAreaId', 'wardArea.wardAreaName', 'citizens.pincode', 'citizens.add1', 'citizens.add2', 'citizens.nativePlace', 'citizens.accNo', 'citizens.partNo', 'citizens.sectionNumber', 'citizens.slnNumberInPart', 'citizens.bjpVoter', 'citizens.created_by', 'citizens.updated_by')
            ->leftjoin('citizens', 'complaint_assigned_karyakarta.karyakartaId', 'citizens.id')
            ->leftjoin('assembly', 'citizens.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'citizens.gaonId', 'gaon.id')
            ->leftjoin('ward', 'citizens.wardId', 'ward.id')
            ->leftjoin('wardArea', 'citizens.wardAreaId', 'wardArea.id')
            ->leftjoin('taluka_panchayats', 'citizens.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'citizens.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('complaint_details', 'complaint_assigned_karyakarta.complaintDetailsId', 'complaint_details.id')
            ->where('complaint_details.id', $complaintDetailsId)->get();

        // Adhikari
        $Adhikari = ComplaintAssignedAdhikari::select('complaint_assigned_adhikari.complaintDetailsId', 'complaint_assigned_adhikari.adhikariId', 'adhikari.firstName', 'adhikari.middleName', 'adhikari.lastName', 'adhikari.gender', 'adhikari.mobileNo', 'adhikari.alternateNo', 'adhikari.departmentId', 'departments.departmentName', 'adhikari.designation', 'adhikari.education', 'adhikari.dateOfBirth', 'adhikari.address', 'adhikari.photo', 'adhikari.created_by', 'adhikari.updated_by')
            ->leftjoin('adhikari', 'complaint_assigned_adhikari.adhikariId', 'adhikari.id')
            ->leftjoin('departments', 'adhikari.departmentId', 'departments.id')
            ->leftjoin('complaint_details', 'complaint_assigned_adhikari.complaintDetailsId', 'complaint_details.id')
            ->where('complaint_details.id', $complaintDetailsId)->get();

        $array = [
            'ComplainerDetails' => $ComplainerDetails,
            'ComplaintDetails' => $ComplaintDetails,
            'ComplaintDetailsDocument' => $result ? $result : null,
            'Karyakarta' => $Karyakarta ? $Karyakarta : null,
            'Adhikari' => $Adhikari ? $Adhikari : null
        ];
        if (count($ComplaintDetails) != 0) {
            return response()->json([
                'code' => 200,
                'ComplainerDetails' => $ComplainerDetails[0],
                'ComplaintDetails' => $ComplaintDetails[0],
                'ComplaintDetailsDocument' => $result,
                'Karyakarta' => $Karyakarta ? $Karyakarta : null,
                'Adhikari' => $Adhikari ? $Adhikari : null,
                'photo'=>$result,
                'message' => 'Complaint Details  Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details  Not Found',
            ]);
        }
    }

    //  View All Complaints By Complainer Id

    public function viewComplaintsByComplainerId($complainerId)
    {
        $ComplainerDetails = ComplaintDetails::select('c.id', 'c.fname', 'c.mname', 'c.lname', 'c.email', 'c.gender', 'c.number', 'c.altNumber', 'c.password', 'c.role', 'c.office', 'c.dob', 'c.education', 'c.occupation', 'c.cast', 'c.subCast', 'c.addNote', 'c.photo', 'c.aadharNumber', 'c.panNumber', 'c.voterId', 'c.rationCard', 'c.assemblyId', 'a.assemblyName', 'c.cityType', 'c.zillaParishadId', 'zp.zillaParishadName', 'c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName', 'c.pincode', 'c.add1', 'c.add2', 'c.nativePlace', 'c.accNo', 'c.partNo', 'c.sectionNumber', 'c.slnNumberInPart', 'c.bjpVoter', 'c.created_by', 'c.updated_by')
            ->leftjoin('citizens as c', 'complaint_details.complainerId', 'c.id')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->leftjoin('assembly as a', 'c.assemblyId', 'a.id')
            ->leftjoin('zilla_parishads as zp', 'c.zillaParishadId', 'zp.id')
            ->where('c.id', $complainerId)
            ->get();

        $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.token', 'complaint_details.complainerId', 'complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.pincode', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status', 'complaint_details.created_by', 'c.fname as createdByFname', 'c.mname as createdByMname', 'c.lname as createdByLname', 'complaint_details.updated_by', 'complaint_details.created_at')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('citizens as c', 'complaint_details.created_by', 'c.id')
            ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
            ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
            ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id')
            ->where('citizens.role', 'Karyakarta')
            ->where('complaint_details.complainerId', $complainerId)->get();

        $array = [
            'ComplainerDetails' => $ComplainerDetails,
            'ComplaintDetails' => $ComplaintDetails,
        ];

        if (count($ComplaintDetails) != 0) {
            return response()->json([
                'code' => 200,
                'Complaint' => $array,
                'message' => 'Complaint Details  Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details  Not Found',
            ]);
        }
    }

    //Update Complaint Details
    // public function update(Request $request, $complaintDetailsId)
    // {
    //     // $request->validate([
    //     //     'complainerId' => 'required',
    //     //     'issue' => 'required',
    //     //     'actualComplaintDate' => 'required',
    //     //     'complaintCategoryId' => 'required',
    //     //     'complaintSubCategoryId' => 'required',
    //     //     'complaintDueDate' => 'required',
    //     //     'address' => 'required',
    //     //     'assemblyId' => 'required',
    //     //     'cityType' => 'required',
    //     //     'gaonId' => '',
    //     //     'talukaPanchayatId' => '',
    //     //     'zillaParishadId' => '',
    //     //     'wardId' => '',
    //     //     'wardAreaId' => '',
    //     //     'followUp' => 'required',
    //     //     'status' => '',
    //     //     'document' => '',
    //     //     'karyakartaId' => '',
    //     //     'adhikariId' => '',
    //     // ]);

    //     $request->validate([
    //         'complainerId' => 'required',
    //         'issue' => 'required',
    //         'actualComplaintDate' => 'required',
    //         'complaintCategoryId' => 'required',
    //         'complaintSubCategoryId' => 'required',
    //         'complaintDueDate' => 'required',
    //         'address' => 'required',
    //         'assemblyId' => 'required',
    //         'cityType' => 'required',
    //         'gaonId' => '',
    //         'talukaPanchayatId' => '',
    //         'zillaParishadId' => '',
    //         'wardId' => '',
    //         'wardAreaId' => '',
    //         'followUp' => 'required',
    //         'status' => '',
    //         'document' => '',
    //         'karyakartaId' => '',
    //         'adhikariId' => '',
    //     ]);

    //     $ComplaintDetails = ComplaintDetails::find($complaintDetailsId);
    //     if ($ComplaintDetails) {
    //         $ComplaintDetails->complainerId = $request->complainerId;
    //         $ComplaintDetails->issue = $request->issue;
    //         $ComplaintDetails->actualComplaintDate = $request->actualComplaintDate;
    //         $ComplaintDetails->complaintCategoryId = $request->complaintCategoryId;
    //         $ComplaintDetails->address = $request->address;
    //         $ComplaintDetails->assemblyId = $request->assemblyId;
    //         $ComplaintDetails->cityType = $request->cityType;
    //         $ComplaintDetails->gaonId = $request->gaonId;
    //         $ComplaintDetails->talukaPanchayatId = $request->talukaPanchayatId;
    //         $ComplaintDetails->zillaParishadId = $request->zillaParishadId;
    //         $ComplaintDetails->wardId = $request->wardId;
    //         $ComplaintDetails->wardAreaId = $request->wardAreaId;
    //         $ComplaintDetails->followUp = $request->followUp;
    //         $ComplaintDetails->status = $request->status;
    //         $ComplaintDetails->update();

    //         if ($request->document) {
    //             // $documents = Images::where('typeId', $complaintDetailsId)->where('documentType', '=', 'ComplaintDetails')->get();
    //             // if ($documents) {
    //             //     $documents->delete();
    //             // }
    //             $documents = Images::where('typeId', $complaintDetailsId)->where('documentType', '=', 'ComplaintDetails')->get();
    //             if ($documents) {
    //                 $documents->delete(); // This is where the error is triggered.
    //             }
    //             $new_name = $ComplaintDetailsDocument . '_' . date('YmdHis') . '.' . $ComplaintDetailsDocument->getClientOriginalExtension();
    //             $ComplaintDetailsDocument->move(public_path('/ComplaintDetailsDocument'), $new_name);
    //             $ComplaintDetailsDocument = new Images();
    //             $ComplaintDetailsDocument->documentName = $new_name;
    //             $ComplaintDetailsDocument->documentType = 'ComplaintDetails';
    //             $ComplaintDetailsDocument->typeId = $ComplaintDetails->id;
    //             $ComplaintDetailsDocument->save();
    //         }

    //         // For Karyakarta
    //         if ($request->karyakartaId) {
    //             $ComplaintAssignedKaryakarta = ComplaintAssignedKaryakarta::where('complaint_assigned_karyakarta.complaintDetailsId', $complaintDetailsId)->get();

    //             if($ComplaintAssignedKaryakarta){
    //                 $ComplaintAssignedKaryakarta->delete();
    //             }
    //             foreach ($request->karyakartaId as $karyakartaId) {
    //                 $karyakarta = new ComplaintAssignedKaryakarta();
    //                 $karyakarta->complaintDetailsId = $ComplaintDetails->id;
    //                 $karyakarta->karyakartaId = $karyakartaId;
    //                 $karyakarta->save();
    //             }
    //         }

    //         // For Adhikari
    //         if ($request->adhikariId) {
    //             $ComplaintAssignedAdhikari = ComplaintAssignedAdhikari::where('complaint_assigned_adhikari.complaintDetailsId', $complaintDetailsId)->get();
    //             if($ComplaintAssignedAdhikari){
    //                 $ComplaintAssignedAdhikari->delete();
    //             }
    //             foreach ($request->adhikariId as $adhikariId) {
    //                 $adhikari = new ComplaintAssignedAdhikari();
    //                 $adhikari->complaintDetailsId = $ComplaintDetails->id;
    //                 $adhikari->adhikariId = $adhikariId;
    //                 $adhikari->save();
    //             }
    //         }

    //         return response()->json([
    //             'code' => 200,
    //             'data' => $ComplaintDetails,
    //             'message' => 'Complaint Details Updated Successfully',
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Complaint Details Not Found',
    //         ]);
    //     }
    // }

    public function update(Request $request, $complaintDetailsId)
    {
        // $data = $request->all();

        $request->validate([
            'complainerId' => 'required',
            'issue' => 'required',
            'actualComplaintDate' => 'required',
            'complaintCategoryId' => 'required',
            'complaintSubCategoryId' => 'required',
            'complaintDueDate' => 'required',
            'address' => 'required',
            'pincode' => '',
            'assemblyId' => 'required',
            'cityType' => 'required',
            'gaonId' => '',
            'talukaPanchayatId' => '',
            'zillaParishadId' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'followUp' => 'required',
            'status' => '',
            'document' => '',
            'karyakartaId' => '',
            'adhikariId' => '',
            'updated_by' => '',
        ]);


        $ComplaintDetails = ComplaintDetails::find($complaintDetailsId);
        $oldImage = $ComplaintDetails->document;
        $imgName = basename($oldImage);

        if ($ComplaintDetails) {
            $ComplaintDetails->complainerId = $request->complainerId;
            $ComplaintDetails->issue = $request->issue;
            $ComplaintDetails->actualComplaintDate = $request->actualComplaintDate;
            $ComplaintDetails->complaintCategoryId = $request->complaintCategoryId;
            $ComplaintDetails->address = $request->address;
            $ComplaintDetails->pincode = $request->pincode;
            $ComplaintDetails->assemblyId = $request->assemblyId;
            $ComplaintDetails->cityType = $request->cityType;
            $ComplaintDetails->gaonId = $request->gaonId;
            $ComplaintDetails->talukaPanchayatId = $request->talukaPanchayatId;
            $ComplaintDetails->zillaParishadId = $request->zillaParishadId;
            $ComplaintDetails->wardId = $request->wardId;
            $ComplaintDetails->wardAreaId = $request->wardAreaId;
            $ComplaintDetails->followUp = $request->followUp;
            $ComplaintDetails->status = $request->status;
            $ComplaintDetails->updated_by = $request->updated_by;
            $ComplaintDetails->update();

            $ComplaintDetailsDocument = '';
            if ($request->hasFile('documentName')) {
                $Images = Images::where('typeId', $ComplaintDetails->id)->where('documentType', 'ComplaintDetails');
                $Images->delete();

                $document = $request->documentName;
                $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                $document->move(public_path('/ComplaintDetailsDocument'), $new_name);

                $ComplaintDetailsDocument = new Images();
                $ComplaintDetailsDocument->documentName = $new_name;
                $ComplaintDetailsDocument->documentType = 'ComplaintDetails';
                $ComplaintDetailsDocument->typeId = $ComplaintDetails->id;
                $ComplaintDetailsDocument->save();

                // $document = $request->file('document');
                // $newName = 'ComplaintDetailsDocument_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                // $document->move(public_path('/ComplaintDetailsDocument'), $newName);

                // $image = new Images();
                // $image->documentName = $newName;
                // $image->documentType = 'ComplaintDetails';
                // $image->typeId = $ComplaintDetails->id;
                // $image->save();
            } 
            // else {
            //     $ComplaintDetails = ComplaintDetails::find($complaintDetailsId);
            //     $oldImage = $ComplaintDetails->document;
            //     $imgName = basename($oldImage);
            //     $image = new Images();
            //     $image->documentName = $imgName;
            //     $image->documentType = 'ComplaintDetails';
            //     $image->typeId = $ComplaintDetails->id;
            //     $image->save();
            // }


            if ($request->has('karyakartaId')) {
                $ComplaintAssignedKaryakarta = ComplaintAssignedKaryakarta::where('complaintDetailsId', $complaintDetailsId);
                $ComplaintAssignedKaryakarta->delete();
                foreach ($request->karyakartaId as $karyakartaId) {
                    $karyakarta = new ComplaintAssignedKaryakarta();
                    $karyakarta->complaintDetailsId = $ComplaintDetails->id;
                    $karyakarta->karyakartaId = $karyakartaId;
                    $karyakarta->save();
                }
            }

            if ($request->has('adhikariId')) {
                $ComplaintAssignedAdhikari = ComplaintAssignedAdhikari::where('complaintDetailsId', $complaintDetailsId);
                $ComplaintAssignedAdhikari->delete();
                foreach ($request->adhikariId as $adhikariId) {
                    $adhikari = new ComplaintAssignedAdhikari();
                    $adhikari->complaintDetailsId = $ComplaintDetails->id;
                    $adhikari->adhikariId = $adhikariId;
                    $adhikari->save();
                }
            }

            // Document
            $Documents = Images::select('images.typeId as complaintDetailsId', 'images.documentName')->where('images.typeId', $complaintDetailsId)->where('images.documentType', 'ComplaintDetails')->get();

            if (count($Documents) != 0) {
                foreach ($Documents as $Document) {
                    $res = [
                        'complaintDetailsId' => $Document->complaintDetailsId,
                        'photo' => 'https://mlaapi.orisunlifescience.coms/public/ComplaintDetailsDocument/' . $Document->documentName,
                    ];
                    $result[] = $res;
                }
            } else {
                $result = null;
            }
            return response()->json([
                'code' => 200,
                'data' => $ComplaintDetails,
                'document' => $result ? $result : null,
                'message' => 'Complaint Details Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details Not Found',
            ], 404);
        }
    }

    // Update status
    public function updateStatus(Request $request, $complaintDetailsId)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $ComplaintDetails = ComplaintDetails::find($complaintDetailsId);
        if ($ComplaintDetails) {
            $ComplaintDetails->status = $request->status;
            $ComplaintDetails->update();
            return response()->json([
                'code' => 200,
                'data' => $ComplaintDetails,
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
    //Delete ComplaintDetails
    public function destroy($complaintDetailsId)
    {
        $ComplaintDetails = ComplaintDetails::find($complaintDetailsId);

        if ($ComplaintDetails) {
            $ComplaintDetails->delete();
            $ComplaintAssignedAdhikari = ComplaintAssignedAdhikari::where('complaint_assigned_adhikari.complaintDetailsId', $complaintDetailsId)->delete();

            $ComplaintAssignedKaryakarta = ComplaintAssignedKaryakarta::where('complaint_assigned_karyakarta.complaintDetailsId', $complaintDetailsId)->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Complaint Details deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details Not Found',
            ]);
        }
    }

    //  filter api
    public function getComplaintDetailsByFilter($complaintCategoryId = null, $complaintSubCategoryId = null, $assemblyId = null, $cityType = null, $wardId = null, $wardAreaId = null, $zillaParishadId = null, $talukaPanchayatId = null, $gaonId = null, $status = null, $FromDate = null, $ToDate = null)
    {
        $query = DB::table('complaint_details as cd')
            ->select(
                'cd.id AS complaintDetailsId',
                'cd.token',
                'cd.complainerId',
                'cd.issue',
                'cd.actualComplaintDate',
                'cd.complaintCategoryId',
                'cc.complaintCategoryName',
                'cd.complaintSubCategoryId',
                'csc.complaintSubCategoryName',
                'cd.complaintDueDate',
                'cd.address',
                'cd.pincode',
                'cd.assemblyId',
                'a.assemblyName',
                'cd.cityType',
                'cd.gaonId',
                'g.gaonName',
                'cd.talukaPanchayatId',
                'cd.zillaParishadId',
                'cd.wardId',
                'w.wardName',
                'cd.wardAreaId',
                'wa.wardAreaName',
                'cd.followUp',
                'cd.status',
                'cd.created_by',
                'cd.updated_by'
            )
            ->leftJoin('citizens as c', 'cd.complainerId', '=', 'c.id')
            ->leftJoin('complaint_category as cc', 'cd.complaintCategoryId', '=', 'cc.id')
            ->leftJoin('complaint_sub_category as csc', 'cd.complaintSubCategoryId', '=', 'csc.id')
            ->leftJoin('assembly as a', 'cd.assemblyId', '=', 'a.id')
            ->leftJoin('gaon as g', 'cd.gaonId', '=', 'g.id')
            ->leftJoin('taluka_panchayats as tp', 'cd.talukaPanchayatId', '=', 'tp.id')
            ->leftJoin('zilla_parishads as zp', 'cd.zillaParishadId', '=', 'zp.id')
            ->leftJoin('ward as w', 'cd.wardId', '=', 'w.id')
            ->leftJoin('wardArea as wa', 'cd.wardAreaId', '=', 'wa.id');

        if ($complaintCategoryId !== 'null' && $complaintCategoryId !== null) {
            $query->where('cd.complaintCategoryId', $complaintCategoryId);
        }

        if ($complaintSubCategoryId !== 'null' && $complaintSubCategoryId !== null) {
            $query->where('cd.complaintSubCategoryId', $complaintSubCategoryId);
        }

        if ($assemblyId !== 'null' && $assemblyId !== null) {
            $query->where('cd.assemblyId', $assemblyId);
        }

        if ($cityType !== 'null' && $cityType !== null) {
            $query->where('cd.cityType', $cityType);
        }

        if ($wardId !== 'null' && $wardId !== null) {
            $query->where('cd.wardId', $wardId);
        }

        if ($wardAreaId !== 'null' && $wardAreaId !== null) {
            $query->where('cd.wardAreaId', $wardAreaId);
        }

        if ($zillaParishadId !== 'null' && $zillaParishadId !== null) {
            $query->where('cd.zillaParishadId', $zillaParishadId);
        }

        if ($talukaPanchayatId !== 'null' && $talukaPanchayatId !== null) {
            $query->where('cd.talukaPanchayatId', $talukaPanchayatId);
        }

        if ($gaonId !== 'null' && $gaonId !== null) {
            $query->where('cd.gaonId', $gaonId);
        }

        if ($status !== 'null' && $status !== null) {
            $query->where('cd.status', $status);
        }

        if ($FromDate !== 'null' && $ToDate !== 'null' && $FromDate !== null && $ToDate !== null) {
            $query->whereBetween('cd.actualComplaintDate', [$FromDate, $ToDate]);
        }

        $data = $query->get();

        $results = [];

        foreach ($data as $item) {
            $res = [
                'complaintDetailsId' => $item->complaintDetailsId,
                'token' => $item->token,
                'complainerId' => $item->complainerId,
                'issue' => $item->issue,
                'actualComplaintDate' => $item->actualComplaintDate,
                'complaintCategoryId' => $item->complaintCategoryId,
                'complaintCategoryName' => $item->complaintCategoryName,
                'complaintSubCategoryId' => $item->complaintSubCategoryId,
                'complaintSubCategoryName' => $item->complaintSubCategoryName,
                'complaintDueDate' => $item->complaintDueDate,
                'address' => $item->address,
                'pincode' => $item->pincode,
                'assemblyId' => $item->assemblyId,
                'assemblyName' => $item->assemblyName,
                'cityType' => $item->cityType,
                'gaonId' => $item->gaonId,
                'gaonName' => $item->gaonName,
                'talukaPanchayatId' => $item->talukaPanchayatId,
                'zillaParishadId' => $item->zillaParishadId,
                'wardId' => $item->wardId,
                'wardName' => $item->wardName,
                'wardAreaId' => $item->wardAreaId,
                'wardAreaName' => $item->wardAreaName,
                'followUp' => $item->followUp,
                'status' => $item->status,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $results[] = $res;
        }

        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $results,
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

    public function ViewComplaintByPagination($pageNo,$pageSize, $token = null, $status = null, $person=null)
    {
        //$count = ComplaintDetails::count();
       // $limit = 25;
       // $totalPage = ceil($count / $limit);
        $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.token', 'complaint_details.complainerId', 'citizens.fname as complainerFname','citizens.mname as complainerMname','citizens.lname as complainerLname','citizens.number as complainerNumber','citizens.talukaPanchayatId as complainerTalukaPanchayatId','tp.talukaPanchayatName as complainerTalukaPanchayatName','citizens.gaonId as complainerGaonId','g.gaonName as complainerGaonName','citizens.wardId as complainerWardId','w.wardName as complainerWardName','citizens.wardAreaId as complainerWardAreaId','wa.wardAreaName as complainerWardAreaName','complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.pincode', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId','taluka_panchayats.talukaPanchayatName', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status', 'complaint_details.created_by', 'c.fname as createdByFname', 'c.mname as createdByMname', 'c.lname as createdByLname', 'complaint_details.updated_by', 'complaint_details.created_at')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('taluka_panchayats as tp', 'citizens.talukaPanchayatId', 'tp.id')
            ->leftjoin('gaon as g', 'citizens.gaonId', 'g.id')
            ->leftjoin('ward as w', 'citizens.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'citizens.wardAreaId', 'wa.id')
            ->leftjoin('citizens as c', 'complaint_details.created_by', 'c.id')
            ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
            ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
            ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id')
            
            // ->with(['complainer', 'createdBy', 'complaintCategory', 'complaintSubCategory', 'assembly', 'gaon', 'talukaPanchayat', 'zillaParishad', 'ward', 'wardArea'])
    ->when($token, function ($query, $token) {
        return $query->where('complaint_details.token', $token);
    })
    ->when($status, function ($query, $status) {
        return $query->where('complaint_details.status', $status);
    })
    ->when($person, function ($query, $person) {
        return $query->where('complaint_details.complainerId', $person);
    })
    ->orderBy('complaint_details.id', 'desc');

    $count = $ComplaintDetails->count();
    $totalPage = ceil($count / $pageSize);

    $ComplaintDetails = $ComplaintDetails
        ->offset(($pageNo - 1) * $pageSize)
        ->limit($pageSize)
        ->get();

    if ($ComplaintDetails->isNotEmpty()) {
        return response()->json([
            'code' => 200,
            'data' => $ComplaintDetails,
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
    // public function ViewComplaintByPagination($pageNo,$pageSize, $token = null, $status = null, $person=null)
    // {
    //     //$count = ComplaintDetails::count();
    //   // $limit = 25;
    //   // $totalPage = ceil($count / $limit);
    //     $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.token', 'complaint_details.complainerId', 'citizens.fname as complainerFname','citizens.mname as complainerMname','citizens.lname as complainerLname','citizens.number as complainerNumber','citizens.talukaPanchayatId as complainerTalukaPanchayatId','tp.talukaPanchayatName as complainerTalukaPanchayatName','citizens.gaonId as complainerGaonId','g.gaonName as complainerGaonName','citizens.wardId as complainerWardId','w.wardName as complainerWardName','citizens.wardAreaId as complainerWardAreaId','wa.wardAreaName as complainerWardAreaName','complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.pincode', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId','taluka_panchayats.talukaPanchayatName', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status', 'complaint_details.created_by', 'c.fname as createdByFname', 'c.mname as createdByMname', 'c.lname as createdByLname', 'complaint_details.updated_by', 'complaint_details.created_at')
    //         ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
    //         ->leftjoin('taluka_panchayats as tp', 'citizens.talukaPanchayatId', 'tp.id')
    //         ->leftjoin('gaon as g', 'citizens.gaonId', 'g.id')
    //         ->leftjoin('ward as w', 'citizens.wardId', 'w.id')
    //         ->leftjoin('wardArea as wa', 'citizens.wardAreaId', 'wa.id')
    //         ->leftjoin('citizens as c', 'complaint_details.created_by', 'c.id')
    //         ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
    //         ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
    //         ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
    //         ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
    //         ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
    //         ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
    //         ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
    //         ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id');
            
    //         if ($token) {
    //             $ComplaintDetails->where('complaint_details.token', $token);
    //         }

    //         if ($status) {
    //              $ComplaintDetails->where('complaint_details.status', $status);
    //          }
    //          if ($person) {
    //              $ComplaintDetails->where('complaint_details.complainerId', $person);
    //          }
             
    //          if ($status && $person) {
    //         $data ->where('I.status', $status)
    //             ->where(function ($query) use ($person) {
    //                 $query->where('complaint_details.complainerId', $person);
    //             });
    //     }
             
    //          if ($token && $person) {
    //         $data->where('I.token', '=', $token)
    //             ->where(function ($query) use ($person) {
    //                 $query->where('complaint_details.complainerId', $person);
                        
    //             });
    //     }
    //     if ($token && $status && $person) {
    //         $data ->where('I.status', $status)
    //         ->where('I.token', '=', $token)
    //         ->where(function ($query) use ($person) {
    //             $query->where('complaint_details.complainerId', $person);
                   
    //         });
    //     }
            
    //     $ComplaintDetails->orderBy('complaint_details.id', 'desc')
    //         // ->selectRaw('ROW_NUMBER() OVER (ORDER BY complaint_details.id desc) AS RowNum');
    //         ->select(DB::raw('ROW_NUMBER() OVER (ORDER BY complaint_details.id desc) AS RowNum'));

            
    //     $count = $ComplaintDetails->count();
    //   //  $limit = 25;
    //     $totalPage = ceil($count / $pageSize);

    //     $subquery = DB::table(DB::raw("({$ComplaintDetails->toSql()}) as sub"))
    //         ->mergeBindings($ComplaintDetails->getQuery()) // Use getQuery() to get the underlying Query\Builder
    //         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);

    //     $ComplaintDetails = $subquery->get();
    //     if (count($ComplaintDetails) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $ComplaintDetails,
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

    // search by token or status
    public function searchComplaintsByTokenOrStatus($token = null, $status = null)
    {
        $query = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.token', 'complaint_details.complainerId', 'citizens.fname as complainerFname','citizens.mname as complainerMname','citizens.lname as complainerLname','citizens.number as complainerNumber','citizens.talukaPanchayatId as complainerTalukaPanchayatId','tp.talukaPanchayatName as complainerTalukaPanchayatName','citizens.gaonId as complainerGaonId','g.gaonName as complainerGaonName','citizens.wardId as complainerWardId','w.wardName as complainerWardName','citizens.wardAreaId as complainerWardAreaId','wa.wardAreaName as complainerWardAreaName','complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.pincode', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId','taluka_panchayats.talukaPanchayatName', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status', 'complaint_details.created_by', 'c.fname as createdByFname', 'c.mname as createdByMname', 'c.lname as createdByLname', 'complaint_details.updated_by', 'complaint_details.created_at')
        ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
        ->leftjoin('taluka_panchayats as tp', 'citizens.talukaPanchayatId', 'tp.id')
        ->leftjoin('gaon as g', 'citizens.gaonId', 'g.id')
        ->leftjoin('ward as w', 'citizens.wardId', 'w.id')
        ->leftjoin('wardArea as wa', 'citizens.wardAreaId', 'wa.id')
        ->leftjoin('citizens as c', 'complaint_details.created_by', 'c.id')
        ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
        ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
        ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
        ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
        ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
        ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
        ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
        ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id');

        if ($token) {
            $query->where('complaint_details.token', $token);
        }

        if ($status) {
            $query->where('complaint_details.status', $status);
        }

        $data = $query->orderBy('complaint_details.id', 'desc')->get();
        return $this->sendResponse($data);
    }

    public function sendResponse($data)
    {
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Complaint Details Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details Not Found',
            ]);
        }
    }
}
