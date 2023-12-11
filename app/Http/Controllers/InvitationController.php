<?php

namespace App\Http\Controllers;

use App\Models\Images;
use App\Models\Invitation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    // public function store(Request $req)
    // {
    //     $Validator = Validator::make($req->all(), [
    //         'eventTypeId' => 'required',
    //         'eventDate' => 'required',
    //         'eventTime' => '',
    //         'mulacheName' => '',
    //         'mulicheName' => '',
    //         'haldiPlace' => '',
    //         'haldidate' => '',
    //         'eventAddress' => '',
    //         'routeId' => '',
    //         'priority' => 'required',
    //         'note' => '',
    //         'assemblyId' => '',
    //         'cityType' => '',
    //         'wardId' => '',
    //         'wardAreaId' => '',
    //         'zillaParishadId' => '',
    //         'talukaPanchayatId' => '',
    //         'gaonId' => '',
    //         'documentName' => '',
    //     ]);

    //     if ($Validator->fails()) {
    //         return response()->json($Validator->errors()->tojson(), 400);
    //     }

    //     $invitation = new Invitation;
    //     $invitation->eventTypeId = $req->eventTypeId;
    //     $invitation->eventDate = $req->eventDate;
    //     $invitation->eventTime = $req->eventTime;
    //     $invitation->eventAddress = $req->eventAddress;
    //     $invitation->mulacheName = $req->mulacheName;
    //     $invitation->mulicheName = $req->mulicheName;
    //     $invitation->haldiPlace = $req->haldiPlace;
    //     $invitation->haldidate = $req->haldidate;
    //     $invitation->routeId = $req->routeId;
    //     $invitation->priority = $req->priority;
    //     $invitation->note = $req->note;
    //     $invitation->assemblyId = $req->assemblyId;
    //     $invitation->cityType = $req->cityType;
    //     $invitation->wardId = $req->wardId;
    //     $invitation->wardAreaId = $req->wardAreaId;
    //     $invitation->zillaParishadId = $req->zillaParishadId;
    //     $invitation->talukaPanchayatId = $req->talukaPanchayatId;
    //     $invitation->gaonId = $req->gaonId;
    //     $invitation->isActive = 1;
    //     $invitation->save();
    //     if ($invitation->id) {
    //         $image = new Images;
    //         if ($req->hasFile('documentName') && $req->file('documentName')->isValid()) {
    //             $fileName = $req->file('documentName');
    //             $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
    //             $name = pathinfo($documentName, PATHINFO_FILENAME);
    //             // $name = str_replace(' ', '_', $fileName);
    //             $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
    //             $fileName->move(public_path('/invitationDocument'), $new_name);
    //             // $fileName->move(public_path('/Document'), $new_name);
    //             $image->documentName = $new_name;
    //             $image->documentType = 'invitation';
    //             $image->typeId = $invitation->id;
    //             $image->isActive = 1;
    //             $image->save();
    //         } else {
    //             echo "file Not saved";
    //         }
    //     }
    //     if($invitation){
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $invitation,
    //             'image' => $image,
    //             'message' => 'Data Added',
    //         ]);
    //     }else{
    //         return response()->json([
    //             'code' => 400,
    //             'data' => [],
    //             'image' => [],
    //             'message' => 'Data Not Added',
    //         ]);
    //     }

    // }

    public function store(Request $req)
    {
        $Validator = Validator::make($req->all(), [
            'eventTypeId' => 'required',
            'eventDate' => 'required',
            'eventTime' => '',
            'invitationfrom' => '',
            'mulacheName' => '',
            'mulacheName' => '',
            'mulicheName' => '',
            'haldiPlace' => '',
            'haldidate' => '',
            'eventAddress' => '',
            'routeId' => '',
            'priority' => 'required',
            'note' => '',
            'assemblyId' => '',
            'cityType' => '',
            'wardId' => '',
            'wardAreaId' => '',
            'zillaParishadId' => '',
            'talukaPanchayatId' => '',
            'gaonId' => '',
            'documentName' => '',
            'userId' => 'required',
        ]);

        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $prefix = "SB-";
        // $fetchToken = DB::table('invitations')->select('token')->orderBy('token', 'desc')->first();

        // if ($fetchToken) {
        //     // Extract the numeric part of the token and increment it by 1
        //     $lastTokenNumber = intval(str_replace($prefix, '', $fetchToken->token));
        //     $newTokenNumber = $lastTokenNumber + 1;

        //     // Create the new token with the prefix
        //     $newToken = $prefix . $newTokenNumber;
        // } else {
        //     // If no existing token found, start with "SB-1"
        //     $newToken = $prefix . 1;
        // }

        // Print or save the new token as needed
        // echo $lastTokenNumber;
        // echo $newToken;

        // exit;

        $invitation = new Invitation;
        // $invitation->token = $newToken;
        $invitation->eventTypeId = $req->eventTypeId;
        $invitation->eventDate = $req->eventDate;
        $invitation->eventTime = $req->eventTime;
        $invitation->eventAddress = $req->eventAddress;
        $invitation->invitationfrom = $req->invitationfrom;
        $invitation->mulacheName = $req->mulacheName;
        $invitation->mulicheName = $req->mulicheName;
        $invitation->haldiPlace = $req->haldiPlace;
        $invitation->haldidate = $req->haldidate;
        $invitation->routeId = $req->routeId;
        $invitation->priority = $req->priority;
        $invitation->note = $req->note;
        $invitation->assemblyId = $req->assemblyId;
        $invitation->cityType = $req->cityType;
        $invitation->wardId = $req->wardId;
        $invitation->wardAreaId = $req->wardAreaId;
        $invitation->zillaParishadId = $req->zillaParishadId;
        $invitation->talukaPanchayatId = $req->talukaPanchayatId;
        $invitation->gaonId = $req->gaonId;
        $invitation->inviterId = $req->inviterId;
        $invitation->referenceId = $req->referenceId;
        $invitation->status = 'Pending';
        $invitation->isActive = 1;
        $invitation->created_by = $req->userId;
        $invitation->save();
        if ($invitation->id) {
            $image = new Images;
            if ($req->hasFile('documentName') && $req->file('documentName')->isValid()) {
                $fileName = $req->file('documentName');
                $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
                $name = pathinfo($documentName, PATHINFO_FILENAME);
                // $name = str_replace(' ', '_', $fileName);
                $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
                $fileName->move(public_path('/invitationDocument'), $new_name);
                $image->documentName = $new_name;
                $image->documentType = 'invitation';
                $image->typeId = $invitation->id;
                $image->isActive = 1;
                $image->save();
            }
            // else {
            //     $image->documentName = NULL;
            //     $image->documentType = 'invitation';
            //     $image->typeId = $invitation->id;
            //     $image->isActive = 1;
            //     $image->save();
            // }
        }

        // Token
        $token = Invitation::where('id', $invitation->id)->update(['token' => 'SB-' . $invitation->id]);

        if ($invitation) {
            return response()->json([
                'code' => 200,
                'data' => $invitation,
                'image' => $image ? $image : null,
                'message' => 'Data Added',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'image' => [],
                'message' => 'Data Not Added',
            ]);
        }
    }

    // public function viewAll()
    // {
    //     $results = DB::table('invitations as I')
    //         ->select('I.id', 'IT.invitationTypeName', 'I.token', 'I.eventDate', 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'I.inviterId', 'I.referenceId')
    //         ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
    //         ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
    //         ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
    //         ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
    //         ->get();

    //     if ($results) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $results,
    //             'message' => 'Invitation List Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Invitation Not Found',
    //         ]);
    //     }
    // }

    // public function viewAll()
    // {
    //     $data = DB::table('invitations as I')
    //         ->select('I.id', 'IT.invitationTypeName', 'I.token', 'I.eventDate', 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'I.inviterId', 'I.referenceId')
    //         ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
    //         ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
    //         ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
    //         ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
    //         ->get();
    //     foreach ($data as $item) {
    //         $res = [
    //             'id' => $item->id,
    //             'invitationTypeName' => $item->invitationTypeName,
    //             'token' => $item->token,
    //             'eventDate' => $item->eventDate,
    //             'priority' => $item->priority,
    //             'routeName' => $item->routeName,
    //             'wardName' => $item->wardName,
    //             'gaonName' => $item->gaonName,
    //             'inviterId' => $item->inviterId,
    //             'referenceId' => $item->referenceId,
    //         ];
    //         $result[] = $res;
    //     }

    //     if (count($data) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $result,
    //             'message' => 'Invitation List Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Invitation Not Found',
    //         ]);
    //     }
    // }

    public function viewAll()
    {
        $data = DB::table('invitations as I')
            ->select('I.id', 'I.eventTypeId', 'IT.invitationTypeName', 'I.token', 'I.eventDate', 'I.eventTime', 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'TP.talukaPanchayatName', 'I.inviterId', 'C.fname as inviterfirstname', 'C.mname as invitermiddlename', 'C.lname as inviterlastname', 'C.number as inviterMobileNumber', 'C.gaonId as inviterGaonId', 'GC.gaonName as inviterGaonName', 'C.talukaPanchayatId as inviterTalukaPanchayatId', 'TC.talukaPanchayatName as inviterTalukaPanchayatName', 'I.referenceId', 'CC.fname as referencefirstname', 'CC.mname as referenceMiddlename', 'CC.lname as referencelastname', 'CC.number as referenceMobileNumber', 'CC.talukaPanchayatId as referenceTalukaPanchayatId', 'TR.talukaPanchayatName as referenceTalukaPanchayatName', 'CC.gaonId as referenceGaonId', 'GR.gaonName as referenceGaonName', 'I.status')
            ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
            ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
            ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
            ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
            ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'I.talukaPanchayatId')
            ->leftJoin('citizens as C', 'I.inviterId', '=', 'C.id')
            ->leftJoin('taluka_panchayats as TC', 'C.talukaPanchayatId', '=', 'TC.id')
            ->leftJoin('gaon as GC', 'C.gaonId', '=', 'GC.id')
            ->leftJoin('citizens as CC', 'I.referenceId', '=', 'CC.id')
            ->leftJoin('taluka_panchayats as TR', 'CC.talukaPanchayatId', '=', 'TR.id')
            ->leftJoin('gaon as GR', 'CC.gaonId', '=', 'GR.id')
            // ->orderBy('I.id', 'desc')
            ->orderBy('I.eventDate', 'asc')
            ->orderBy('I.eventTime', 'asc')
            ->get();
        return $this->sendResponse($data);
    }

    // public function viewInvitationById($id)
    // {
    //     //select I.id, I.token, I.eventTypeId, IT.invitationTypeName as Event_Name, I.even.haldidate, I.routeId as Route, tDate, I.eventTime, I.eventAddress, I.mulacheName, I.mulicheName, I.haldiPlace, IR.routeName as Route_name, I.priority, I.note, I.assemblyId, A.assemblyName as assembly_name, I.cityType, I.wardId, W.wardName as Ward_name, I.wardAreaId, WA.wardAreaName as Ward_area_name, I.zillaParishadId, ZP.zillaParishadName, I.talukaPanchayatId,TP.talukaPanchayatName,  I.gaonId, G.gaonName, I.inviterId, C.fname as InviterName, C.email as InviterEmail, I.referenceId, ct.fname as ReferenceName, ct.email as refrenceEmail, im.documentName, im.documentType from invitations as I
    //     // LEFT JOIN invitation_types as IT ON IT.id = eventTypeId
    //     // LEFT JOIN routes as R ON R.id = I.id
    //     // LEFT JOIN assembly as A ON A.id = I.id
    //     // LEFT JOIN ward as W ON W.id = I.wardId
    //     // LEFT JOIN wardarea as WA ON WA.id = I.wardAreaId
    //     // LEFT JOIN zilla_parishads as ZP ON ZP.id = I.zillaParishadId
    //     // LEFT JOIN taluka_panchayats as TP ON TP.id = I.id
    //     // LEFT JOIN gaon as G ON G.id = I.gaonId
    //     // LEFT JOIN citizens as C ON C.id = I.inviterId
    //     // LEFT JOIN citizens as ct ON ct.id = I.referenceId
    //     // LEFT JOIN images as im ON  im.typeId = I.id
    //     // WHERE im.documentType = "invitation" OR "NULL"
    //     $invitation = DB::table('invitations as I')
    //         ->select(
    //             'I.id', 'I.token', 'I.eventTypeId', DB::raw('IT.invitationTypeName as Event_Name'),
    //             'I.eventDate', 'I.eventTime', 'I.eventAddress', 'I.mulacheName', 'I.mulicheName',
    //             'I.haldiPlace', 'I.haldidate', 'I.routeId as Route', DB::raw('R.routeName as Route_name'),
    //             'I.priority', 'I.note', 'I.assemblyId', DB::raw('A.assemblyName as assembly_name'),
    //             'I.cityType', 'I.wardId', DB::raw('W.wardName as Ward_name'),
    //             'I.wardAreaId', DB::raw('WA.wardAreaName as Ward_area_name'),
    //             'I.zillaParishadId', 'ZP.zillaParishadName', 'I.talukaPanchayatId', DB::raw('TP.talukaPanchayatName'),
    //             'I.gaonId', 'G.gaonName', 'I.inviterId',
    //             DB::raw('C.fname as InviterName'), DB::raw('C.email as InviterEmail'),
    //             'I.referenceId',
    //             DB::raw('ct.fname as ReferenceName'), DB::raw('ct.email as refrenceEmail')
    //         )
    //         ->leftJoin('invitation_types as IT', 'IT.id', '=', 'I.eventTypeId')
    //         ->leftJoin('routes as R', 'R.id', '=', 'I.routeId')
    //         ->leftJoin('assembly as A', 'A.id', '=', 'I.assemblyId')
    //         ->leftJoin('ward as W', 'W.id', '=', 'I.wardId')
    //         ->leftJoin('wardArea as WA', 'WA.id', '=', 'I.wardAreaId')
    //         ->leftJoin('zilla_parishads as ZP', 'ZP.id', '=', 'I.zillaParishadId')
    //         ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'I.talukaPanchayatId')
    //         ->leftJoin('gaon as G', 'G.id', '=', 'I.gaonId')
    //         ->leftJoin('citizens as C', 'C.id', '=', 'I.inviterId')
    //         ->leftJoin('citizens as ct', 'ct.id', '=', 'I.referenceId')
    //         ->where('I.id', $id)
    //         ->first();

    //     // foreach ($invitation as $item) {
    //     //     $res = [
    //     //         'id' => $item->id,
    //     //         'token' => $item->token,
    //     //         'eventTypeId' => $item->eventTypeId,
    //     //         'Event_Name' => $item->Event_Name,
    //     //         'eventDate' => $item->eventDate,
    //     //         'eventTime' => $item->eventTime,
    //     //         'eventAddress' => $item->eventAddress,
    //     //         'mulacheName' => $item->mulacheName,
    //     //         'mulicheName' => $item->mulicheName,
    //     //         'haldiPlace' => $item->haldiPlace,
    //     //         'haldidate' => $item->haldidate,
    //     //         'Route' => $item->Route,
    //     //         'Route_name' => $item->Route_name,
    //     //         'priority' => $item->priority,
    //     //         'note' => $item->note,
    //     //         'assemblyId' => $item->assemblyId,
    //     //         'assembly_name' => $item->assembly_name,
    //     //         'cityType' => $item->cityType,
    //     //         'wardId' => $item->wardId,
    //     //         'Ward_name' => $item->Ward_name,
    //     //         'wardAreaId' => $item->wardAreaId,
    //     //         'Ward_area_name' => $item->Ward_area_name,
    //     //         'zillaParishadId' => $item->zillaParishadId,
    //     //         'zillaParishadName' => $item->zillaParishadName,
    //     //         'talukaPanchayatId' => $item->talukaPanchayatId,
    //     //         'talukaPanchayatName' => $item->talukaPanchayatName,
    //     //         'gaonId' => $item->gaonId,
    //     //         'gaonName' => $item->gaonName,
    //     //         'inviterId' => $item->inviterId,
    //     //         'InviterName' => $item->InviterName,
    //     //         'InviterEmail' => $item->InviterEmail,
    //     //         'referenceId' => $item->referenceId,
    //     //         'ReferenceName' => $item->ReferenceName,
    //     //         'refrenceEmail' => $item->refrenceEmail,
    //     //     ];
    //     //     $results[] = $res;
    //     // }

    //     if ($invitation) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $invitation,
    //             'message' => 'Invitation Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Invitations Not Found',
    //         ]);
    //     }
    // }
    public function viewInvitationById($id)
    {
        try {
            $path = 'https://mlaapi.orisunlifescience.com/public/invitationDocument/';
            // InvitationDetails
            $InvitationDetails = DB::table('invitations as I')
                ->select(
                    'I.id',
                    'I.token',
                    'I.eventTypeId',
                    DB::raw('IT.invitationTypeName as Event_Name'),
                    'I.eventDate',
                   // DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"),
                   DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"),

                   // DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i'), '%h:%i %p') as eventTime"),

                    'I.eventAddress',
                    'I.mulacheName',
                    'I.mulicheName',
                    'I.haldiPlace',
                    'I.haldidate',
                    'I.routeId as Route',
                    DB::raw('R.routeName as Route_name'),
                    'I.priority',
                    'I.note',
                    'I.assemblyId',
                    DB::raw('A.assemblyName as assembly_name'),
                    'I.cityType',
                    'I.wardId',
                    DB::raw('W.wardName as Ward_name'),
                    'I.wardAreaId',
                    DB::raw('WA.wardAreaName as Ward_area_name'),
                    'I.zillaParishadId',
                    'ZP.zillaParishadName',
                    'I.talukaPanchayatId',
                    DB::raw('TP.talukaPanchayatName'),
                    'I.gaonId',
                    'G.gaonName',
                    'I.inviterId',
                    DB::raw('C.fname as InviterName'),
                    DB::raw('C.email as InviterEmail'),
                    DB::raw('C.number as InviterNumber'),
                    DB::raw('C.occupation as InviterOccupation'),
                    'I.referenceId',
                    DB::raw('ct.fname as ReferenceName'),
                    DB::raw('ct.email as refrenceEmail'),
                    DB::raw('C.number as refrenceNumber'),
                    DB::raw('C.occupation as refrenceOccupation'),
                    'Img.documentName',
                    'I.created_by',
                    DB::raw('cb.fname as createdByFname'),
                    DB::raw('cb.mname as createdByMname'),
                    DB::raw('cb.lname as createdByLname'),
                    'I.updated_by',
                    DB::raw('ub.fname as updatedByFname'),
                    DB::raw('ub.mname as updatedByMname'),
                    DB::raw('ub.lname as updatedByLname'),
                    'I.created_at',
                    'I.updated_at',
                    'I.status'
                )
                ->leftJoin('invitation_types as IT', 'IT.id', '=', 'I.eventTypeId')
                ->leftJoin('routes as R', 'R.id', '=', 'I.routeId')
                ->leftJoin('assembly as A', 'A.id', '=', 'I.assemblyId')
                ->leftJoin('ward as W', 'W.id', '=', 'I.wardId')
                ->leftJoin('wardArea as WA', 'WA.id', '=', 'I.wardAreaId')
                ->leftJoin('zilla_parishads as ZP', 'ZP.id', '=', 'I.zillaParishadId')
                ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'I.talukaPanchayatId')
                ->leftJoin('gaon as G', 'G.id', '=', 'I.gaonId')
                ->leftJoin('citizens as C', 'C.id', '=', 'I.inviterId')
                ->leftJoin('citizens as ct', 'ct.id', '=', 'I.referenceId')
                ->leftJoin('citizens as cb', 'cb.id', '=', 'I.created_by')
                ->leftJoin('citizens as ub', 'ub.id', '=', 'I.updated_by')
                ->leftJoin('images as Img', 'I.id', '=', 'Img.typeId')
                ->where('I.id', $id)
                //->where('Img.documentType', 'invitation')
                ->orwhere('Img.typeId', '$id')
                ->first();

            // ->getQuery();
            // $invitationQuery =  $InvitationDetails->toSql();
            // InvitorDetails
            $InvitorDetails = DB::table('invitations as I')->select('I.inviterId', 'C.fname', 'C.mname', 'C.lname', 'C.number', 'C.cityType', 'C.gaonId', 'G.gaonName', 'C.talukaPanchayatId', 'TP.talukaPanchayatName', 'C.wardId', 'W.wardName', 'C.occupation')
                ->leftjoin('citizens as C', 'I.inviterId', '=', 'C.id')
                ->leftjoin('gaon as G', 'C.gaonId', '=', 'G.id')
                ->leftjoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
                ->leftjoin('ward as W', 'C.wardId', '=', 'W.id')
                ->where('I.id', $id)
                ->get();
            // ->getQuery();
            // $InvitorDetailsQuery =  $InvitorDetails->toSql();

            // ReferenceDetails
            $ReferenceDetails = DB::table('invitations as I')->select('I.referenceId', 'C.fname', 'C.mname', 'C.lname', 'C.number', 'C.cityType', 'C.gaonId', 'G.gaonName', 'C.talukaPanchayatId', 'TP.talukaPanchayatName', 'C.wardId', 'W.wardName', 'C.occupation')
                ->leftjoin('citizens as C', 'I.inviterId', '=', 'C.id')
                ->leftjoin('gaon as G', 'C.gaonId', '=', 'G.id')
                ->leftjoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
                ->leftjoin('ward as W', 'C.wardId', '=', 'W.id')
                ->where('I.id', $id)
                // ->getQuery();
                ->get();
            // $ReferenceDetailsQuery =  $ReferenceDetails->toSql();

            if ($InvitationDetails) {
                return response()->json([
                    'code' => 200,
                    'id' => $id,
                    'data' => $InvitationDetails,
                    'InvitorDetails' => $InvitorDetails,
                    'ReferenceDetails' => $ReferenceDetails,
                    'message' => 'Invitation Fetched',
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'data' => [],
                    'message' => 'Invitations Not Found',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => [],
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(Request $req, $id)
    {
        $req->validate([
            'status' => 'required',
            'userId' => 'required',
        ]);
        // $data = InfluentialPersons::find($id);
        $data = Invitation::find($id);
        if ($data) {
            $data->status = $req->status;
            $data->updated_by = $req->userId;
            $data->update();
            return response()->json([
                'code' => 200,
                'data' => $data,
                'message' => 'Data Updated',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Found',
            ]);
        }
    }

    public function getInvitationsByFilter($priority = null, $status = null, $eventTypeId = null, $routeid = null, $assemblyid = null, $cityType = null, $FromDate = null, $ToDate = null)
    {
        $query = DB::table('invitations as I')
            ->select(
                'I.id',
                'IT.invitationTypeName',
                'I.token',
                'I.eventDate',
                DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"),
                'I.priority',
                'R.routeName',
                'W.wardName',
                'G.gaonName',
                'I.inviterId',
                'I.referenceId',
                'I.created_by',
                'I.updated_by'
            )
            ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
            ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
            ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
            ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
            ->leftJoin('assembly as A', 'I.assemblyId', '=', 'A.id');

        if ($priority !== 'null' && $priority !== null) {
            $query->where('I.priority', $priority);
        }

        if ($status !== 'null' && $status !== null) {
            $query->where('I.status', $status);
        }

        if ($eventTypeId !== 'null' && $eventTypeId !== null) {
            $query->where('I.eventTypeId', $eventTypeId);
        }

        if ($routeid !== 'null' && $routeid !== null) {
            $query->where('I.routeId', $routeid);
        }

        if ($assemblyid !== 'null' && $assemblyid !== null) {
            $query->where('I.assemblyId', $assemblyid);
        }

        if ($cityType !== 'null' && $cityType !== null) {
            $query->where('I.cityType', $cityType);
        }

        if ($FromDate !== 'null' && $ToDate !== 'null' && $FromDate !== null && $ToDate !== null) {
            $query->whereBetween('I.eventDate', [$FromDate, $ToDate]);
        }

        $data = $query->get();

        $results = [];

        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'invitationTypeName' => $item->invitationTypeName,
                'token' => $item->token,
                'eventDate' => $item->eventDate,
                'eventTime' => $item->eventTime,
                'priority' => $item->priority,
                'routeName' => $item->routeName,
                'wardName' => $item->wardName,
                'gaonName' => $item->gaonName,
                'inviterId' => $item->inviterId,
                'referenceId' => $item->referenceId,
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

    public function getInvitationsByFilterNew($priority = null, $status = null, $eventTypeId = null, $routeid = null, $assemblyid = null, $cityType = null, $wardId = null, $wardAreaId = null, $gaonId = null, $talukaPanchayatId = null, $zillaParishadId = null, $FromDate = null, $ToDate = null)
    {
        $query = DB::table('invitations as I')
            ->select(
                'I.id',
                'IT.invitationTypeName',
                'I.token',
                'I.eventTypeId',
                'I.eventDate',
                'I.eventTime',
                'I.priority',
                'R.routeName',
                'R.id as RouteId',
                'W.wardName',
                'W.id as WardId',
                'WA.wardAreaName',
                'WA.id as wardAreaId',
                'A.id as AssemblyId',
                'A.assemblyName',
                'G.gaonName',
                'G.id as GaonId',
                'I.inviterId',
                'I.referenceId',
                'TP.id as TPId',
                'TP.talukaPanchayatName',
                'ZP.id as ZPId',
                'ZP.zillaParishadName',
                'I.status',
                'I.cityType',
                'I.created_by',
                'I.updated_by'
            )
            ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
            ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
            ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
            ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
            ->leftJoin('assembly as A', 'I.assemblyId', '=', 'A.id')
            ->leftJoin('wardArea as WA', 'WA.id', '=', 'I.wardAreaId')
            ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'I.talukaPanchayatId')
            ->leftJoin('zilla_parishads as ZP', 'ZP.id', '=', 'I.zillaParishadId');


        if ($priority !== 'null' && $priority !== null) {
            $query->where('I.priority', $priority);
        }

        if ($status !== 'null' && $status !== null) {
            $query->where('I.status', $status);
        }

        if ($eventTypeId !== 'null' && $eventTypeId !== null) {
            $query->where('I.eventTypeId', $eventTypeId);
        }

        if ($routeid !== 'null' && $routeid !== null) {
            $query->where('I.routeId', $routeid);
        }

        if ($assemblyid !== 'null' && $assemblyid !== null) {
            $query->where('I.assemblyId', $assemblyid);
        }

        if ($cityType !== 'null' && $cityType !== null) {
            $query->where('I.cityType', $cityType);
        }

        if ($wardId !== 'null' && $wardId !== null) {
            $query->where('I.wardId', $wardId);
        }

        if ($wardAreaId !== 'null' && $wardAreaId !== null) {
            $query->where('I.wardAreaId', $wardAreaId);
        }

        if ($gaonId !== 'null' && $gaonId !== null) {
            $query->where('I.gaonId', $gaonId);
        }

        if ($talukaPanchayatId !== 'null' && $talukaPanchayatId !== null) {
            $query->where('I.talukaPanchayatId', $talukaPanchayatId);
        }

        if ($zillaParishadId !== 'null' && $zillaParishadId !== null) {
            $query->where('I.zillaParishadId', $zillaParishadId);
        }

        if ($FromDate !== 'null' && $ToDate !== 'null' && $FromDate !== null && $ToDate !== null) {
            $query->whereBetween('I.eventDate', [$FromDate, $ToDate]);
        }

        $data = $query->get();

        $results = [];

        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'invitationTypeName' => $item->invitationTypeName,
                'token' => $item->token,
                'eventTypeId' => $item->eventTypeId,
                'eventDate' => $item->eventDate,
                'eventTime' => $item->eventTime,
                'priority' => $item->priority,
                'RouteId' => $item->RouteId,
                'routeName' => $item->routeName,
                'WardId' => $item->WardId,
                'wardName' => $item->wardName,
                'wardAreaId' => $item->wardAreaId,
                'wardAreaName' => $item->wardAreaName,
                'assemblyName' => $item->assemblyName,
                'AssemblyId' => $item->AssemblyId,
                'gaonName' => $item->gaonName,
                'GaonId' => $item->GaonId,
                'inviterId' => $item->inviterId,
                'referenceId' => $item->referenceId,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'TPId' => $item->TPId,
                'zillaParishadName' => $item->zillaParishadName,
                'ZPId' => $item->ZPId,
                'status' => $item->status,
                'cityType' => $item->cityType,
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

    // public function viewInvitationByPagination($pageNo, $pageSize, $token = null, $status = null, $person = null)
    // {
    //     // $count = Invitation::count();
    //     // $limit = 25;
    //     // $totalPage = ceil($count / $limit);
    //     $data = DB::table('invitations as I')
    //         ->select('I.id', 'I.eventTypeId', 'IT.invitationTypeName', 'I.token', 'I.eventDate', DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"), 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'TP.talukaPanchayatName', 'I.inviterId', 'C.fname as inviterfirstname', 'C.mname as invitermiddlename', 'C.lname as inviterlastname', 'C.number as inviterMobileNumber', 'C.gaonId as inviterGaonId', 'GC.gaonName as inviterGaonName', 'C.talukaPanchayatId as inviterTalukaPanchayatId', 'TC.talukaPanchayatName as inviterTalukaPanchayatName', 'I.referenceId', 'CC.fname as referencefirstname', 'CC.mname as referenceMiddlename', 'CC.lname as referencelastname', 'CC.number as referenceMobileNumber', 'CC.talukaPanchayatId as referenceTalukaPanchayatId', 'TR.talukaPanchayatName as referenceTalukaPanchayatName', 'CC.gaonId as referenceGaonId', 'GR.gaonName as referenceGaonName', 'I.status')
    //         ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
    //         ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
    //         ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
    //         ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
    //         ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'I.talukaPanchayatId')
    //         ->leftJoin('citizens as C', 'I.inviterId', '=', 'C.id')
    //         ->leftJoin('taluka_panchayats as TC', 'C.talukaPanchayatId', '=', 'TC.id')
    //         ->leftJoin('gaon as GC', 'C.gaonId', '=', 'GC.id')
    //         ->leftJoin('citizens as CC', 'I.referenceId', '=', 'CC.id')
    //         ->leftJoin('taluka_panchayats as TR', 'CC.talukaPanchayatId', '=', 'TR.id')
    //         ->leftJoin('gaon as GR', 'CC.gaonId', '=', 'GR.id');

    //     if ($token) {
    //         $data->where('I.token', $token);
    //     }
    //     if ($status) {
    //         $data->where('I.status', $status);
    //     }
    //     if ($person) {
    //         $data->where('I.inviterId', $person)->orwhere('I.referenceId', $person);
    //     }

    //     if ($status && $person) {
    //         $data ->where('I.status', $status)
    //             ->where(function ($query) use ($person) {
    //                 $query->where('I.inviterId', $person)
    //                     ->orWhere('I.referenceId', $person);
    //             });
    //     }
    //     if ($token && $person) {
    //         $data->where('I.token', '=', $token)
    //             ->where(function ($query) use ($person) {
    //                 $query->where('I.inviterId', $person)
    //                     ->orWhere('I.referenceId', $person);
    //             });
    //     }
    //     if ($token && $status && $person) {
    //         $data ->where('I.status', $status)
    //         ->where('I.token', '=', $token)
    //         ->where(function ($query) use ($person) {
    //             $query->where('I.inviterId', $person)
    //                 ->orWhere('I.referenceId', $person);
    //         });
    //     }

    //     // ->orderBy('I.id')
    //     $data->orderBy('I.id', 'desc')
    //         ->selectRaw('ROW_NUMBER() OVER (ORDER BY I.id desc) AS RowNum');

    //     $count = $data->count();
    //     // $limit = 25;
    //     $totalPage = ceil($count / $pageSize);

    //     $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
    //         ->mergeBindings($data)
    //         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);
    //     $data = $subquery->get();
    //     // return $this->sendResponse($data);
    //     foreach ($data as $item) {
    //         $res = [
    //             'id' => $item->id,
    //             'eventTypeId' => $item->eventTypeId,
    //             'invitationTypeName' => $item->invitationTypeName,
    //             'token' => $item->token,
    //             'eventDate' => $item->eventDate,
    //             'eventTime' => $item->eventTime,
    //             'priority' => $item->priority,
    //             'routeName' => $item->routeName,
    //             'wardName' => $item->wardName,
    //             'gaonName' => $item->gaonName,
    //             'talukaPanchayatName' => $item->talukaPanchayatName,
    //             'inviterId' => $item->inviterId,
    //             'inviterfirstname' => $item->inviterfirstname, 'invitermiddlename' => $item->invitermiddlename,
    //             'inviterlastname' => $item->inviterlastname,
    //             'inviterMobileNumber' => $item->inviterMobileNumber,
    //             'inviterGaonId' => $item->inviterGaonId,
    //             'inviterGaonName' => $item->inviterGaonName,
    //             'inviterTalukaPanchayatId' => $item->inviterTalukaPanchayatId,
    //             'inviterTalukaPanchayatName' => $item->inviterTalukaPanchayatName,
    //             'referenceId' => $item->referenceId,
    //             'inviterGaonId' => $item->inviterGaonId,
    //             'referencefirstname' => $item->referencefirstname,
    //             'referenceMiddlename' => $item->referenceMiddlename,
    //             'referencelastname' => $item->referencelastname,
    //             'referenceMobileNumber' => $item->referenceMobileNumber,
    //             'referenceTalukaPanchayatId' => $item->referenceTalukaPanchayatId,
    //             'referenceTalukaPanchayatName' => $item->referenceTalukaPanchayatName,
    //             'referenceGaonId' => $item->referenceGaonId,
    //             'referenceGaonName' => $item->referenceGaonName,
    //             'status' => $item->status,
    //         ];
    //         $result[] = $res;
    //     }

    //     if (count($data) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $result,
    //             'currentPage' => $pageNo,
    //             'totalPage' => $totalPage,
    //             'count' => $count,
    //             'message' => 'Invitation List Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Invitation Not Found',
    //         ]);
    //     }
    // }
    
    public function viewInvitationByPagination($pageNo, $pageSize, $token = null, $status = null, $person = null)
{
    $query = Invitation::select(
        'invitations.id',
        'invitations.eventTypeId',
        'invitation_types.invitationTypeName',
        'invitations.token',
        'invitations.eventDate',
        DB::raw("TIME_FORMAT(STR_TO_DATE(invitations.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"),
        'invitations.priority',
        'routes.routeName',
        'ward.wardName',
        'gaon.gaonName',
        'taluka_panchayats.talukaPanchayatName',
        'invitations.inviterId',
        'citizens.fname as inviterfirstname',
        'citizens.mname as invitermiddlename',
        'citizens.lname as inviterlastname',
        'citizens.number as inviterMobileNumber',
        'citizens.gaonId as inviterGaonId',
        'gaon_citizens.gaonName as inviterGaonName',
        'citizens.talukaPanchayatId as inviterTalukaPanchayatId',
        'taluka_panchayats_citizens.talukaPanchayatName as inviterTalukaPanchayatName',
        'invitations.referenceId',
        'reference_citizens.fname as referencefirstname',
        'reference_citizens.mname as referenceMiddlename',
        'reference_citizens.lname as referencelastname',
        'reference_citizens.number as referenceMobileNumber',
        'reference_citizens.talukaPanchayatId as referenceTalukaPanchayatId',
        'taluka_panchayats_reference.talukaPanchayatName as referenceTalukaPanchayatName',
        'reference_citizens.gaonId as referenceGaonId',
        'gaon_reference_citizens.gaonName as referenceGaonName',
        'invitations.status'
    )
    ->leftJoin('invitation_types', 'invitations.eventTypeId', '=', 'invitation_types.id')
    ->leftJoin('routes', 'invitations.routeId', '=', 'routes.id')
    ->leftJoin('ward', 'invitations.wardId', '=', 'ward.id')
    ->leftJoin('gaon', 'invitations.gaonId', '=', 'gaon.id')
    ->leftJoin('taluka_panchayats', 'taluka_panchayats.id', '=', 'invitations.talukaPanchayatId')
    ->leftJoin('citizens', 'invitations.inviterId', '=', 'citizens.id')
    ->leftJoin('taluka_panchayats as taluka_panchayats_citizens', 'citizens.talukaPanchayatId', '=', 'taluka_panchayats_citizens.id')
    ->leftJoin('gaon as gaon_citizens', 'citizens.gaonId', '=', 'gaon_citizens.id')
    ->leftJoin('citizens as reference_citizens', 'invitations.referenceId', '=', 'reference_citizens.id')
    ->leftJoin('taluka_panchayats as taluka_panchayats_reference', 'reference_citizens.talukaPanchayatId', '=', 'taluka_panchayats_reference.id')
    ->leftJoin('gaon as gaon_reference_citizens', 'reference_citizens.gaonId', '=', 'gaon_reference_citizens.id');

    if ($token) {
        $query->where('invitations.token', $token);
    }

    if ($status) {
        $query->where('invitations.status', $status);
    }

    if ($person) {
        $query->where(function ($q) use ($person) {
            $q->where('invitations.inviterId', $person)
                ->orWhere('invitations.referenceId', $person);
        });
    }

    if ($status && $person) {
        $query->where(function ($q) use ($status, $person) {
            $q->where('invitations.status', $status)
                ->where(function ($q) use ($person) {
                    $q->where('invitations.inviterId', $person)
                        ->orWhere('invitations.referenceId', $person);
                });
        });
    }

    if ($token && $person) {
        $query->where(function ($q) use ($token, $person) {
            $q->where('invitations.token', $token)
                ->where(function ($q) use ($person) {
                    $q->where('invitations.inviterId', $person)
                        ->orWhere('invitations.referenceId', $person);
                });
        });
    }

    if ($token && $status && $person) {
        $query->where('invitations.status', $status)
            ->where('invitations.token', $token)
            ->where(function ($q) use ($person) {
                $q->where('invitations.inviterId', $person)
                    ->orWhere('invitations.referenceId', $person);
            });
    }

    $count = $query->count();
    $totalPage = ceil($count / $pageSize);

    $invitations = $query
        ->orderBy('invitations.id', 'desc')
        ->offset(($pageNo - 1) * $pageSize)
        ->limit($pageSize)
        ->get();

    if ($invitations->isNotEmpty()) {
        return response()->json([
            'code' => 200,
            'data' => $invitations,
            'currentPage' => $pageNo,
            'totalPage' => $totalPage,
            'count' => $count,
            'message' => 'Invitation List Fetched',
        ]);
    } else {
        return response()->json([
            'code' => 404,
            'data' => [],
            'message' => 'Invitation Not Found',
        ]);
    }
}


    public function viewAllInvitationBydate($FromDate, $ToDate)
    {
        $data = DB::table('invitations as I')
            ->select('I.id', 'IT.invitationTypeName', 'I.token', 'I.eventDate',  DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"), 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'I.inviterId', 'C.fname as inviterfirstname', 'C.lname as inviterlastname', 'I.referenceId', 'CC.fname as referencefirstname', 'CC.lname as referencelastname', 'I.status')
            ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
            ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
            ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
            ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
            ->leftJoin('citizens as C', 'I.inviterId', '=', 'C.id')
            ->leftJoin('citizens as CC', 'I.referenceId', '=', 'CC.id')
            ->whereBetween('I.eventDate', [$FromDate, $ToDate])
            ->orderBy('I.eventDate', 'asc')
            ->orderBy('I.eventTime', 'asc')
            ->get();
        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'invitationTypeName' => $item->invitationTypeName,
                'token' => $item->token,
                'eventDate' => $item->eventDate,
                'eventTime' => $item->eventTime,
                'priority' => $item->priority,
                'routeName' => $item->routeName,
                'wardName' => $item->wardName,
                'gaonName' => $item->gaonName,
                'inviterId' => $item->inviterId,
                'inviterfirstname' => $item->inviterfirstname,
                'inviterlastname' => $item->inviterlastname,
                'referenceId' => $item->referenceId,
                'referencefirstname' => $item->referencefirstname,
                'referencelastname' => $item->referencelastname,
                'status' => $item->status,
            ];
            $result[] = $res;
        }

        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'message' => 'Invitation List Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Not Found',
            ]);
        }
    }

    // public function viewInvitationByPagination($pageNo)
    // {
    //     $data = DB::table('invitations as I')
    //         ->select('I.id', 'IT.invitationTypeName', 'I.token', 'I.eventDate', 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'I.inviterId', 'C.fname as inviterfirstname', 'C.lname as inviterlastname', 'I.referenceId', 'CC.fname as referencefirstname', 'CC.lname as referencelastname', 'I.status')
    //         ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
    //         ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
    //         ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
    //         ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
    //         ->leftJoin('citizens as C', 'I.inviterId', '=', 'C.id')
    //         ->leftJoin('citizens as CC', 'I.referenceId', '=', 'CC.id')
    //         ->orderBy('I.id')
    //         ->selectRaw('ROW_NUMBER() OVER (ORDER BY I.id) AS RowNum');
    //     $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
    //         ->mergeBindings($data)
    //         ->whereBetween('RowNum', [($pageNo - 1) * 25 + 1, $pageNo * 25]);
    //     $data = $subquery->get();
    //     foreach ($data as $item) {
    //         $res = [
    //             'id' => $item->id,
    //             'invitationTypeName' => $item->invitationTypeName,
    //             'token' => $item->token,
    //             'eventDate' => $item->eventDate,
    //             'priority' => $item->priority,
    //             'routeName' => $item->routeName,
    //             'wardName' => $item->wardName,
    //             'gaonName' => $item->gaonName,
    //             'inviterId' => $item->inviterId,
    //             'inviterfirstname' => $item->inviterfirstname,
    //             'inviterlastname' => $item->inviterlastname,
    //             'referenceId' => $item->referenceId,
    //             'referencefirstname' => $item->referencefirstname,
    //             'referencelastname' => $item->referencelastname,
    //             'status' => $item->status,
    //         ];
    //         $result[] = $res;
    //     }

    //     if (count($data) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $result,
    //             'message' => 'Invitation List Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'Invitation Not Found',
    //         ]);
    //     }
    // }

    // Search by token or status
    public function searchInvitationByTokenOrStatus($token = null, $status = null)
    {
        $query = DB::table('invitations as I')
            ->select('I.id', 'I.eventTypeId', 'IT.invitationTypeName', 'I.token', 'I.eventDate',  DB::raw("TIME_FORMAT(STR_TO_DATE(I.eventTime, '%H:%i:%s'), '%h:%i %p') as eventTime"), 'I.priority', 'R.routeName', 'W.wardName', 'G.gaonName', 'TP.talukaPanchayatName', 'I.inviterId', 'C.fname as inviterfirstname', 'C.mname as invitermiddlename', 'C.lname as inviterlastname', 'C.number as inviterMobileNumber', 'C.gaonId as inviterGaonId', 'GC.gaonName as inviterGaonName', 'C.talukaPanchayatId as inviterTalukaPanchayatId', 'TC.talukaPanchayatName as inviterTalukaPanchayatName', 'I.referenceId', 'CC.fname as referencefirstname', 'CC.mname as referenceMiddlename', 'CC.lname as referencelastname', 'CC.number as referenceMobileNumber', 'CC.talukaPanchayatId as referenceTalukaPanchayatId', 'TR.talukaPanchayatName as referenceTalukaPanchayatName', 'CC.gaonId as referenceGaonId', 'GR.gaonName as referenceGaonName', 'I.status')
            ->leftJoin('invitation_types as IT', 'I.eventTypeId', '=', 'IT.id')
            ->leftJoin('routes as R', 'I.routeId', '=', 'R.id')
            ->leftJoin('ward as W', 'I.wardId', '=', 'W.id')
            ->leftJoin('gaon as G', 'I.gaonId', '=', 'G.id')
            ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'I.talukaPanchayatId')
            ->leftJoin('citizens as C', 'I.inviterId', '=', 'C.id')
            ->leftJoin('taluka_panchayats as TC', 'C.talukaPanchayatId', '=', 'TC.id')
            ->leftJoin('gaon as GC', 'C.gaonId', '=', 'GC.id')
            ->leftJoin('citizens as CC', 'I.referenceId', '=', 'CC.id')
            ->leftJoin('taluka_panchayats as TR', 'CC.talukaPanchayatId', '=', 'TR.id')
            ->leftJoin('gaon as GR', 'CC.gaonId', '=', 'GR.id');

        if ($token) {
            $query->where('I.token', $token);
        }

        if ($status) {
            $query->where('I.status', $status);
        }

        $data = $query->get();
        return $this->sendResponse($data);
    }

    public function sendResponse($data)
    {
        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'eventTypeId' => $item->eventTypeId,
                'invitationTypeName' => $item->invitationTypeName,
                'token' => $item->token,
                'eventDate' => $item->eventDate,
                'eventTime' => $item->eventTime,
                'priority' => $item->priority,
                'routeName' => $item->routeName,
                'wardName' => $item->wardName,
                'gaonName' => $item->gaonName,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'inviterId' => $item->inviterId,
                'inviterfirstname' => $item->inviterfirstname, 'invitermiddlename' => $item->invitermiddlename,
                'inviterlastname' => $item->inviterlastname,
                'inviterMobileNumber' => $item->inviterMobileNumber,
                'inviterGaonId' => $item->inviterGaonId,
                'inviterGaonName' => $item->inviterGaonName,
                'inviterTalukaPanchayatId' => $item->inviterTalukaPanchayatId,
                'inviterTalukaPanchayatName' => $item->inviterTalukaPanchayatName,
                'referenceId' => $item->referenceId,
                'inviterGaonId' => $item->inviterGaonId,
                'referencefirstname' => $item->referencefirstname,
                'referenceMiddlename' => $item->referenceMiddlename,
                'referencelastname' => $item->referencelastname,
                'referenceMobileNumber' => $item->referenceMobileNumber,
                'referenceTalukaPanchayatId' => $item->referenceTalukaPanchayatId,
                'referenceTalukaPanchayatName' => $item->referenceTalukaPanchayatName,
                'referenceGaonId' => $item->referenceGaonId,
                'referenceGaonName' => $item->referenceGaonName,
                'status' => $item->status,
            ];
            $result[] = $res;
        }

        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'message' => 'Invitation List Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Not Found',
            ]);
        }
    }
    
     //Delete ComplaintCategory
    public function deleteInvitation($invitationId)
    {
        $InvitorDetails = Invitation::find($invitationId);

        if ($InvitorDetails) {
            $InvitorDetails->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Invitation deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Invitation Not Found',
            ]);
        }
    }
    
}
