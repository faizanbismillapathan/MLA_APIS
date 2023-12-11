<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ComplaintDetails;
use App\Models\Images;
use App\Models\ComplaintAssignedAdhikari;
use App\Models\ComplaintAssignedKaryakarta;

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
        $ComplaintDetails->assemblyId = $request->assemblyId;
        $ComplaintDetails->cityType = $request->cityType;
        $ComplaintDetails->gaonId = $request->gaonId;
        $ComplaintDetails->talukaPanchayatId = $request->talukaPanchayatId;
        $ComplaintDetails->zillaParishadId = $request->zillaParishadId;
        $ComplaintDetails->wardId = $request->wardId;
        $ComplaintDetails->wardAreaId = $request->wardAreaId;
        $ComplaintDetails->followUp = $request->followUp;
        $ComplaintDetails->status = $request->status;
        $ComplaintDetails->save();

        //  For document
        if ($request->hasfile('document')) {
            $i = 0;
            foreach ($request->file('document') as $file) {
                $newfile = $file . '_' . date('YmdHis') . $i . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/ComplaintDetailsDocument'), $newfile);
                $ComplaintDetailsDocument = new Images();
                $ComplaintDetailsDocument->documentName = $newfile;
                $ComplaintDetailsDocument->documentType = 'ComplaintDetails';
                $ComplaintDetailsDocument->typeId = $ComplaintDetails->id;
                $ComplaintDetails->save();
                $i++;
            }
        }
        // if ($request->document) {
        //     foreach ($request->document as $document) {
        //         $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
        //         $document->move(public_path('/ComplaintDetailsDocument'), $new_name);
        //         $ComplaintDetailsDocument = new Images();
        //         $ComplaintDetailsDocument->documentName = $new_name;
        //         $ComplaintDetailsDocument->documentType = 'Complaint';
        //         $ComplaintDetailsDocument->typeId = $ComplaintDetails->id;
        //         $ComplaintDetailsDocument->save();
        //     }
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
                'data' => $ComplaintDetails,
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


    // issue,actualComplaintDate,complaintCategoryId,complaintSubCategoryId,complaintDueDate,address,assemblyId,cityType,gaonId,talukaPanchayatId,zillaParishadId,wardId,wardAreaId,followUp,document,karyakartaId,adhikariId

    // View All ComplaintDetails
    public function index()
    {
        $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.complainerId', 'complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
            ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
            ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id')
            ->get();
        if (count($ComplaintDetails) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $ComplaintDetails,
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

    //View ComplaintDetails By Id
    public function show($complaintDetailsId)
    {
        $ComplainerDetails = ComplaintDetails::select('citizens.id', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'citizens.password', 'citizens.role', 'citizens.office', 'citizens.dob', 'citizens.education', 'citizens.occupation', 'citizens.cast', 'citizens.subCast', 'citizens.addNote', 'citizens.photo', 'citizens.aadharNumber', 'citizens.panNumber', 'citizens.voterId', 'citizens.rationCard', 'citizens.assemblyId', 'citizens.cityType', 'citizens.zillaParishadId', 'citizens.talukaPanchayatId', 'citizens.gaonId', 'gaon.gaonName', 'citizens.wardId', 'citizens.wardAreaId', 'citizens.pincode', 'citizens.add1', 'citizens.add2', 'citizens.nativePlace', 'citizens.accNo', 'citizens.partNo', 'citizens.sectionNumber', 'citizens.slnNumberInPart', 'citizens.bjpVoter')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('gaon', 'citizens.gaonId', 'gaon.id')
            ->where('complaint_details.id', $complaintDetailsId)
            ->get();

        $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.complainerId', 'complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('complaint_category', 'complaint_details.complaintCategoryId', 'complaint_category.id')
            ->leftjoin('complaint_sub_category', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.id')
            ->leftjoin('assembly', 'complaint_details.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'complaint_details.gaonId', 'gaon.id')
            ->leftjoin('taluka_panchayats', 'complaint_details.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'complaint_details.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('ward', 'complaint_details.wardId', 'ward.id')
            ->leftjoin('wardArea', 'complaint_details.wardAreaId', 'wardArea.id')
            ->where('complaint_details.id', $complaintDetailsId)->get();

        // 'complaintDetailsId','karyakartaId' adhikariId

        $Karyakarta = ComplaintAssignedKaryakarta::select('complaint_assigned_karyakarta.complaintDetailsId', 'complaint_assigned_karyakarta.karyakartaId', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'citizens.password', 'citizens.role', 'citizens.office', 'citizens.dob', 'citizens.education', 'citizens.occupation', 'citizens.cast', 'citizens.subCast', 'citizens.addNote', 'citizens.photo', 'citizens.aadharNumber', 'citizens.panNumber', 'citizens.voterId', 'citizens.rationCard', 'citizens.assemblyId','assembly.assemblyName', 'citizens.cityType', 'citizens.zillaParishadId','zilla_parishads.zillaParishadName', 'citizens.talukaPanchayatId','taluka_panchayats.talukaPanchayatName', 'citizens.gaonId', 'gaon.gaonName', 'citizens.wardId','ward.wardName', 'citizens.wardAreaId','wardArea.wardAreaName', 'citizens.pincode', 'citizens.add1', 'citizens.add2', 'citizens.nativePlace', 'citizens.accNo', 'citizens.partNo', 'citizens.sectionNumber', 'citizens.slnNumberInPart', 'citizens.bjpVoter')
            ->leftjoin('citizens', 'complaint_assigned_karyakarta.karyakartaId', 'citizens.id')
            ->leftjoin('assembly', 'citizens.assemblyId', 'assembly.id')
            ->leftjoin('gaon', 'citizens.gaonId', 'gaon.id')
            ->leftjoin('ward', 'citizens.wardId', 'ward.id')
            ->leftjoin('wardArea', 'citizens.wardAreaId', 'wardArea.id')
            ->leftjoin('taluka_panchayats', 'citizens.talukaPanchayatId', 'taluka_panchayats.id')
            ->leftjoin('zilla_parishads', 'citizens.zillaParishadId', 'zilla_parishads.id')
            ->leftjoin('complaint_details', 'complaint_assigned_karyakarta.complaintDetailsId', 'complaint_details.id')
            ->where('complaint_details.id', $complaintDetailsId)->get();

        // contct no name
        $Adhikari = ComplaintAssignedAdhikari::select('complaint_assigned_adhikari.complaintDetailsId', 'complaint_assigned_adhikari.adhikariId', 'adhikari.firstName', 'adhikari.middleName', 'adhikari.lastName', 'adhikari.gender', 'adhikari.mobileNo', 'adhikari.alternateNo', 'adhikari.departmentId', 'departments.departmentName', 'adhikari.designation', 'adhikari.education', 'adhikari.dateOfBirth', 'adhikari.address', 'adhikari.photo')
            ->leftjoin('adhikari', 'complaint_assigned_adhikari.adhikariId', 'adhikari.id')
            ->leftjoin('departments', 'adhikari.departmentId', 'departments.id')
            ->leftjoin('complaint_details', 'complaint_assigned_adhikari.complaintDetailsId', 'complaint_details.id')
            ->where('complaint_details.id', $complaintDetailsId)->get();

        $array = [
            'ComplainerDetails' => $ComplainerDetails,
            'ComplaintDetails' => $ComplaintDetails,
            'Karyakarta' => $Karyakarta ? $Karyakarta : null,
            'Adhikari' => $Adhikari ? $Adhikari : null
        ];
        if (count($ComplaintDetails) != 0) {
            return response()->json([
                'code' => 200,
                'ComplainerDetails' => $ComplainerDetails[0],
                'ComplaintDetails' => $ComplaintDetails[0],
                'Karyakarta' => $Karyakarta ? $Karyakarta : null,
                'Adhikari' => $Adhikari ? $Adhikari : null,
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
        $ComplainerDetails = ComplaintDetails::select('citizens.id', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'citizens.password', 'citizens.role', 'citizens.office', 'citizens.dob', 'citizens.education', 'citizens.occupation', 'citizens.cast', 'citizens.subCast', 'citizens.addNote', 'citizens.photo', 'citizens.aadharNumber', 'citizens.panNumber', 'citizens.voterId', 'citizens.rationCard', 'citizens.assemblyId', 'citizens.cityType', 'citizens.zillaParishadId', 'citizens.talukaPanchayatId', 'citizens.gaonId', 'gaon.gaonName', 'citizens.wardId', 'citizens.wardAreaId', 'citizens.pincode', 'citizens.add1', 'citizens.add2', 'citizens.nativePlace', 'citizens.accNo', 'citizens.partNo', 'citizens.sectionNumber', 'citizens.slnNumberInPart', 'citizens.bjpVoter')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
            ->leftjoin('gaon', 'citizens.gaonId', 'gaon.id')
            ->where('citizens.id', $complainerId)
            ->get();

        $ComplaintDetails = ComplaintDetails::select('complaint_details.id as complaintDetailsId', 'complaint_details.complainerId', 'complaint_details.issue', 'complaint_details.actualComplaintDate', 'complaint_details.complaintCategoryId', 'complaint_category.complaintCategoryName', 'complaint_details.complaintSubCategoryId', 'complaint_sub_category.complaintSubCategoryName', 'complaint_details.complaintDueDate', 'complaint_details.address', 'complaint_details.assemblyId', 'assembly.assemblyName', 'complaint_details.cityType', 'complaint_details.gaonId', 'gaon.gaonName', 'complaint_details.talukaPanchayatId', 'complaint_details.zillaParishadId', 'complaint_details.wardId', 'ward.wardName', 'complaint_details.wardAreaId', 'wardArea.wardAreaName', 'complaint_details.followUp', 'complaint_details.status')
            ->leftjoin('citizens', 'complaint_details.complainerId', 'citizens.id')
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

    //Update Adhikari
    public function update(Request $request, $complaintDetailsId)
    {
        $request->validate([
            'complainerId' => 'required',
            'issue' => 'required',
            'actualComplaintDate' => 'required',
            'complaintCategoryId' => 'required',
            'complaintSubCategoryId' => 'required',
            'complaintDueDate' => 'required',
            'address' => 'required',
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
        ]);

        $ComplaintDetails = ComplaintDetails::find($complaintDetailsId);
        if ($ComplaintDetails) {
            $ComplaintDetails->complainerId = $request->complainerId;
            $ComplaintDetails->issue = $request->issue;
            $ComplaintDetails->actualComplaintDate = $request->actualComplaintDate;
            $ComplaintDetails->complaintCategoryId = $request->complaintCategoryId;
            $ComplaintDetails->complaintSubCategoryId = $request->complaintSubCategoryId;
            $ComplaintDetails->address = $request->address;
            $ComplaintDetails->assemblyId = $request->assemblyId;
            $ComplaintDetails->cityType = $request->cityType;
            $ComplaintDetails->talukaPanchayatId = $request->talukaPanchayatId;
            $ComplaintDetails->wardId = $request->wardId;
            $ComplaintDetails->wardAreaId = $request->wardAreaId;
            $ComplaintDetails->followUp = $request->followUp;
            $ComplaintDetails->status = $request->status;
            $ComplaintDetails->update();

            if ($request->document) {
                foreach ($request->document as $document) {
                    $new_name = $document . '_' . date('YmdHis') . '.' . $document->getClientOriginalExtension();
                    $document->move(public_path('/ComplaintDetailsDocument'), $new_name);
                    $ComplaintDetailsDocument = new Images();
                    $ComplaintDetailsDocument->documentName = $new_name;
                    $ComplaintDetailsDocument->documentType = 'Complaint';
                    $ComplaintDetailsDocument->typeId = $ComplaintDetails->id;
                    $ComplaintDetailsDocument->save();
                }
            }

            // For Karyakarta
            if ($request->karyakartaId) {
                $ComplaintAssignedKaryakarta = ComplaintAssignedKaryakarta::where('complaint_assigned_karyakarta.complaintDetailsId', $complaintDetailsId)->get();
                $ComplaintAssignedKaryakarta->delete();
                $ComplaintAssignedKaryakarta->delete();
                foreach ($request->karyakartaId as $karyakartaId) {
                    $karyakarta = new ComplaintAssignedKaryakarta();
                    $karyakarta->complaintDetailsId = $ComplaintDetails->id;
                    $karyakarta->karyakartaId = $karyakartaId;
                    $karyakarta->save();
                }
            }

            // For Adhikari
            if ($request->adhikariId) {
                $ComplaintAssignedAdhikari = ComplaintAssignedAdhikari::where('complaint_assigned_adhikari.complaintDetailsId', $complaintDetailsId)->get();
                $ComplaintAssignedAdhikari->delete();
                $ComplaintAssignedAdhikari->delete();
                foreach ($request->adhikariId as $adhikariId) {
                    $adhikari = new ComplaintAssignedAdhikari();
                    $adhikari->complaintDetailsId = $ComplaintDetails->id;
                    $adhikari->adhikariId = $adhikariId;
                    $adhikari->save();
                }
            }
            return response()->json([
                'code' => 200,
                'data' => $ComplaintDetails,
                'message' => 'Complaint Details Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Complaint Details Not Found',
            ]);
        }
    }

    // Update status
    public function updateStatus(Request $request, $complaintDetailsId){
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
}
