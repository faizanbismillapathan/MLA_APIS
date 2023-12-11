<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use App\Models\Adhikari;
use Carbon\Carbon;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'fname' => 'required',
            'mname' => '',
            'lname' => 'required',
            'email' => '',
            'gender' => '',
            'number' => 'required',
            'altNumber' => '',
            'password' => '',
            'role' => '',
            'office' => '',
            'dob' => '',
            'education',
            'occupation',
            'cast' => '',
            'subCast' => '',
            'addNote',
            'photo' => '',
            'aadharNumber' => '',
            'panNumber' => '',
            'voterId' => '',
            'rationCard' => '',
            'assemblyId' => '',
            'cityType' => '',
            'zillaParishadId',
            'talukaPanchayatId',
            'gaonId',
            'wardId',
            'wardAreaId',
            'pincode' => '',
            'add1',
            'add2',
            'nativePlace',
            'accNo' => '',
            'partNo' => '',
            'sectionNumber' => '',
            'slnNumberInPart' => '',
            'bjpVoter' => '',
            'userId' => 'required',
        ]);
        // $user = User::create(array_merge($Validator->validated()));
        $users = new User();
        $users->fname = $request->fname;
        $users->mname = $request->mname;
        $users->lname = $request->lname;
        $users->email = $request->email;
        $users->gender = $request->gender;
        $users->number = $request->number;
        $users->altNumber = $request->altNumber;
        $users->password = Hash::make($request->input('password'));
        $users->role = $request->role;
        $users->office = $request->office;
        $users->dob = $request->dob;
        $users->education = $request->education;
        $users->occupation = $request->occupation;
        $users->cast = $request->cast;
        $users->subCast = $request->subCast;
        $users->addNote = $request->addNote;
        $users->aadharNumber = $request->aadharNumber;
        $users->panNumber = $request->panNumber;
        $users->voterId = $request->voterId;
        $users->rationCard = $request->rationCard;
        $users->assemblyId = $request->assemblyId;
        $users->cityType = $request->cityType;
        $users->zillaParishadId = $request->zillaParishadId;
        $users->talukaPanchayatId = $request->talukaPanchayatId;
        $users->gaonId = $request->gaonId;
        $users->wardId = $request->wardId;
        $users->wardAreaId = $request->wardAreaId;
        $users->pincode = $request->pincode;
        $users->add1 = $request->add1;
        $users->add2 = $request->add2;
        $users->nativePlace = $request->nativePlace;
        $users->accNo = $request->accNo;
        $users->partNo = $request->partNo;
        $users->sectionNumber = $request->sectionNumber;
        $users->slnNumberInPart = $request->slnNumberInPart;
        $users->bjpVoter = $request->bjpVoter;
        $users->created_by = $request->userId;
        $users->photo = $request->photo;
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $new_name = date('YmdHis') . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('/Photo'), $new_name);
            $users->photo = $new_name;
        } else {
            $users->photo = 'NULL';
        }
        $users->save();
        if ($users) {
            return response()->json([
                'code' => 200,
                'data' => $users,
                'message' => 'User Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'User Not Added',
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'fname' => '',
            'mname' => '',
            'lname' => '',
            'email' => '',
            'gender' => '',
            'number' => '',
            'altNumber' => '',
            'role' => '',
            'office' => '',
            'dob' => '',
            'education',
            'occupation',
            'cast' => '',
            'subCast' => '',
            'addNote',
            'photo' => '',
            'aadharNumber' => '',
            'panNumber' => '',
            'voterId' => '',
            'rationCard' => '',
            'assemblyId' => '',
            'cityType' => '',
            'zillaParishadId',
            'talukaPanchayatId',
            'gaonId',
            'wardId',
            'wardAreaId',
            'pincode' => '',
            'add1',
            'add2',
            'nativePlace',
            'accNo' => '',
            'partNo' => '',
            'sectionNumber' => '',
            'slnNumberInPart' => '',
            'bjpVoter' => '',
            'updated_by' => 'required',
        ]);

        $user = User::find($id);
        $old_image = $user->photo;
        $imageName = basename($old_image);
        // echo $imageName;
        // exit;
        if ($user) {
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->number = $request->number;
            $user->altNumber = $request->altNumber;
            $user->role = $request->role;
            $user->office = $request->office;
            $user->dob = $request->dob;
            $user->education = $request->education;
            $user->occupation = $request->occupation;
            $user->cast = $request->cast;
            $user->subCast = $request->subCast;
            $user->addNote = $request->addNote;
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photo = $request->file('photo');
                $new_name = date('YmdHis') . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('/Photo'), $new_name);
                $user->photo = $new_name;
            } else {
                $user->photo = $imageName;
            }
            $user->aadharNumber = $request->aadharNumber;
            $user->panNumber = $request->panNumber;
            $user->voterId = $request->voterId;
            $user->rationCard = $request->rationCard;
            $user->assemblyId = $request->assemblyId;
            $user->cityType = $request->cityType;
            $user->zillaParishadId = $request->zillaParishadId;
            $user->talukaPanchayatId = $request->talukaPanchayatId;
            $user->gaonId = $request->gaonId;
            $user->wardId = $request->wardId;
            $user->wardAreaId = $request->wardAreaId;
            $user->pincode = $request->pincode;
            $user->add1 = $request->add1;
            $user->add2 = $request->add2;
            $user->nativePlace = $request->nativePlace;
            $user->accNo = $request->accNo;
            $user->partNo = $request->partNo;
            $user->sectionNumber = $request->sectionNumber;
            $user->slnNumberInPart = $request->slnNumberInPart;
            $user->bjpVoter = $request->bjpVoter;
            $user->updated_by = $request->updated_by;
            $user->update();
            return response()->json([
                'code' => 200,
                'data' => $user,
                'message' => 'Citize Updated Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Citizen Not Updated',
            ]);
        }
    }

    // public function viewByContactNumberAndAadharNumber($contact = null, $aadhar = null)
    // {
    //     $results = DB::table('citizens as C')
    //         ->select(
    //             'C.id', 'C.fname', 'C.mname', 'C.lname', 'C.email', 'C.gender', 'C.number', 'C.altNumber', 'C.role', 'C.office', 'C.dob', 'C.education', 'C.occupation', 'C.cast', 'C.subCast', 'C.addNote', 'C.aadharNumber', 'C.panNumber', 'C.voterId', 'C.rationCard', 'C.assemblyId', 'C.cityType',
    //             'C.zillaParishadId', 'C.talukaPanchayatId', 'C.gaonId', 'ZP.zillaParishadName', 'TP.talukaPanchayatName', 'G.gaonName', 'W.wardName', 'WA.wardAreaName'
    //         )
    //         ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
    //         ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
    //         ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
    //         ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
    //         ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
    //         ->where(function ($query) use ($contact, $aadhar) {
    //             $query->where('C.number', $contact)
    //                 ->orWhere('C.aadharNumber', $aadhar);
    //         })
    //         ->get();
    //     if ($results) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $results,
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

    //  public function viewByContactNumberAndAadharNumber($contact = null, $aadhar = null)
    // {
    //     $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
    //     $data = DB::table('citizens as C')
    //         ->select(
    //             'C.id', 'C.fname', 'C.mname', 'C.lname', 'C.email', 'C.gender', 'C.number', 'C.altNumber', 'C.role', 'C.office', 'C.dob', 'C.education', 'C.occupation', 'C.cast', 'C.subCast', 'C.addNote', 'C.photo', 'C.aadharNumber', 'C.panNumber', 'C.voterId', 'C.rationCard', 'C.assemblyId', 'C.cityType', 'C.zillaParishadId', 'C.talukaPanchayatId', 'C.gaonId', 'ZP.zillaParishadName', 'TP.talukaPanchayatName', 'G.gaonName', 'W.wardName', 'WA.wardAreaName'
    //         )
    //         ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
    //         ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
    //         ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
    //         ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
    //         ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
    //         ->where(function ($query) use ($contact, $aadhar) {
    //             $query->where('C.number', $contact)
    //                 ->orWhere('C.aadharNumber', $aadhar);
    //         })
    //         ->get();
    //     foreach ($data as $item) {
    //         $res = [
    //             'id' => $item->id,
    //             'fname' => $item->fname,
    //             'mname' => $item->mname,
    //             'lname' => $item->lname,
    //             'email' => $item->email,
    //             'gender' => $item->gender,
    //             'number' => $item->number,
    //             'altNumber' => $item->altNumber,
    //             'role' => $item->role,
    //             'office' => $item->office,
    //             'dob' => $item->dob,
    //             'education' => $item->education,
    //             'occupation' => $item->occupation,
    //             'cast' => $item->cast,
    //             'subCast' => $item->subCast,
    //             'addNote' => $item->addNote,
    //             'photo' => $path . $item->photo,
    //             'aadharNumber' => $item->aadharNumber,
    //             'panNumber' => $item->panNumber,
    //             'voterId' => $item->voterId,
    //             'rationCard' => $item->rationCard,
    //             'assemblyId' => $item->assemblyId,
    //             'cityType' => $item->cityType,
    //             'zillaParishadId' => $item->zillaParishadId,
    //             'talukaPanchayatId' => $item->talukaPanchayatId,
    //             'gaonId' => $item->gaonId,
    //             'zillaParishadName' => $item->zillaParishadName,
    //             'talukaPanchayatName' => $item->talukaPanchayatName,
    //             'gaonName' => $item->gaonName,
    //             'wardName' => $item->wardName,
    //             'wardAreaName' => $item->wardAreaName,
    //         ];
    //         $results[] = $res;
    //     }
    //     if ($results) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $results,
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

    // public function viewCitizenByContactNumberAndAadharNumberAndName($contact = null, $aadhar = null, $fname = null)
    // {
    //     $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
    //     $data = DB::table('citizens as C')
    //         ->select(
    //             'C.id',
    //             'C.fname',
    //             'C.mname',
    //             'C.lname',
    //             'C.email',
    //             'C.gender',
    //             'C.number',
    //             'C.altNumber',
    //             'C.role',
    //             'C.office',
    //             'C.dob',
    //             'C.education',
    //             'C.occupation',
    //             'C.cast',
    //             'C.subCast',
    //             'C.addNote',
    //             'C.photo',
    //             'C.aadharNumber',
    //             'C.panNumber',
    //             'C.voterId',
    //             'C.rationCard',
    //             'C.assemblyId',
    //             'A.assemblyName',
    //             'C.cityType',
    //             'C.zillaParishadId',
    //             'C.talukaPanchayatId',
    //             'C.gaonId',
    //             'C.bjpVoter',
    //             'ZP.zillaParishadName',
    //             'TP.talukaPanchayatName',
    //             'G.gaonName',
    //             'W.wardName',
    //             'WA.wardAreaName',
    //             'C.created_by',
    //             'C.updated_by'
    //         )
    //         ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
    //         ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
    //         ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
    //         ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
    //         ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
    //         ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
    //         ->where(function ($query) use ($contact, $aadhar, $fname) {
    //             $query->where('C.number', $contact)
    //                 ->orWhere('C.aadharNumber', $aadhar)
    //                 ->orWhere('C.fname', $fname);
    //         })
    //         ->get();
    //     foreach ($data as $item) {
    //         $res = [
    //             'id' => $item->id,
    //             'fname' => $item->fname,
    //             'mname' => $item->mname,
    //             'lname' => $item->lname,
    //             'email' => $item->email,
    //             'gender' => $item->gender,
    //             'number' => $item->number,
    //             'altNumber' => $item->altNumber,
    //             'role' => $item->role,
    //             'office' => $item->office,
    //             'dob' => $item->dob,
    //             'education' => $item->education,
    //             'occupation' => $item->occupation,
    //             'cast' => $item->cast,
    //             'subCast' => $item->subCast,
    //             'addNote' => $item->addNote,
    //             'photo' => $path . $item->photo,
    //             'aadharNumber' => $item->aadharNumber,
    //             'panNumber' => $item->panNumber,
    //             'voterId' => $item->voterId,
    //             'rationCard' => $item->rationCard,
    //             'assemblyId' => $item->assemblyId,
    //             'assemblyName' => $item->assemblyName,
    //             'cityType' => $item->cityType,
    //             'zillaParishadId' => $item->zillaParishadId,
    //             'talukaPanchayatId' => $item->talukaPanchayatId,
    //             'gaonId' => $item->gaonId,
    //             'zillaParishadName' => $item->zillaParishadName,
    //             'talukaPanchayatName' => $item->talukaPanchayatName,
    //             'gaonName' => $item->gaonName,
    //             'wardName' => $item->wardName,
    //             'wardAreaName' => $item->wardAreaName,
    //             'bjpVoter' => $item->bjpVoter,
    //             'created_by' => $item->created_by,
    //             'updated_by' => $item->updated_by,
    //         ];
    //         $results[] = $res;
    //     }
    //     if (count($data) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $results,
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

   /* public function viewCitizenByContactNumberAndAadharNumberAndName($pageNo,$pageSize,$contact = null, $aadhar = null, $searchValue = null)
    {
        $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $data = DB::table('citizens as C')
            ->select(
                'C.id',
                'C.fname',
                'C.mname',
                'C.lname',
                'C.email',
                'C.gender',
                'C.number',
                'C.altNumber',
                'C.role',
                'C.office',
                'C.dob',
                'C.education',
                'C.occupation',
                'C.cast',
                'C.subCast',
                'C.addNote',
                'C.photo',
                'C.aadharNumber',
                'C.panNumber',
                'C.voterId',
                'C.rationCard',
                'C.assemblyId',
                'A.assemblyName',
                'C.cityType',
                'C.zillaParishadId',
                'C.talukaPanchayatId',
                'C.gaonId',
                'C.bjpVoter',
                'ZP.zillaParishadName',
                'TP.talukaPanchayatName',
                'G.gaonName',
                'W.wardName',
                'WA.wardAreaName',
                'C.created_by',
                'C.updated_by'
            )
            ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
            ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
            ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
            ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
            ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')

            ->where(function ($query) use ($contact, $aadhar) {
                $query->where('C.number', $contact)
                    ->orWhere('C.aadharNumber', $aadhar);
            })
            ->when($searchValue, function ($query) use ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('C.fname', 'like', '%' . $searchValue . '%')
                        ->orWhere('C.lname', 'like', '%' . $searchValue . '%')
                        ->orWhere('C.mname', 'like', '%' . $searchValue . '%');
                })->orWhere(function ($query) use ($searchValue) {
                    $searchValueParts = explode(' ', $searchValue);
                    $query->where(function ($query) use ($searchValueParts) {
                        $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%')
                            ->where('C.lname', 'like', '%' . end($searchValueParts) . '%');
                    })
                    ->orWhere(function ($query) use ($searchValueParts) {
                        $query->where('C.fname', 'like', '%' . end($searchValueParts) . '%')
                            ->where('C.lname', 'like', '%' . $searchValueParts[0] . '%');
                    })
                    ->orWhere(function ($query) use ($searchValueParts) {
                        $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%')
                            ->where('C.mname', 'like', '%' . end($searchValueParts) . '%');
                    })
                    ->orWhere(function ($query) use ($searchValueParts) {
                        $query->where('C.mname', 'like', '%' . $searchValueParts[0] . '%')
                            ->where('C.lname', 'like', '%' . end($searchValueParts) . '%');
                    });
                });
            });

            $data->orderBy('citizens.id', 'desc')
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY citizens.id desc) AS RowNum');

        $count = $data->count();
      //  $limit = 25;
        $totalPage = ceil($count / $pageSize);

        $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
            ->mergeBindings($data->getQuery()) // Use getQuery() to get the underlying Query\Builder
            ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);

        $data = $subquery->get();
        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'fname' => $item->fname,
                'mname' => $item->mname,
                'lname' => $item->lname,
                'email' => $item->email,
                'gender' => $item->gender,
                'number' => $item->number,
                'altNumber' => $item->altNumber,
                'role' => $item->role,
                'office' => $item->office,
                'dob' => $item->dob,
                'education' => $item->education,
                'occupation' => $item->occupation,
                'cast' => $item->cast,
                'subCast' => $item->subCast,
                'addNote' => $item->addNote,
                'photo' => $path . $item->photo,
                'aadharNumber' => $item->aadharNumber,
                'panNumber' => $item->panNumber,
                'voterId' => $item->voterId,
                'rationCard' => $item->rationCard,
                'assemblyId' => $item->assemblyId,
                'assemblyName' => $item->assemblyName,
                'cityType' => $item->cityType,
                'zillaParishadId' => $item->zillaParishadId,
                'talukaPanchayatId' => $item->talukaPanchayatId,
                'gaonId' => $item->gaonId,
                'zillaParishadName' => $item->zillaParishadName,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'gaonName' => $item->gaonName,
                'wardName' => $item->wardName,
                'wardAreaName' => $item->wardAreaName,
                'bjpVoter' => $item->bjpVoter,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $results[] = $res;
        }
        if (count($data) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $results,
                'currentPage'=>$pageNo,
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
    }*/
    //Vipul
    //  public function viewCitizenByContactNumberAndAadharNumberAndName($pageNo,$pageSize,$contact = null, $aadhar = null, $searchValue = null)
    // {
    //     $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
    //     $data = DB::table('citizens as C')
    //         ->select(
    //             'C.id',
    //             'C.fname',
    //             'C.mname',
    //             'C.lname',
    //             'C.email',
    //             'C.gender',
    //             'C.number',
    //             'C.altNumber',
    //             'C.role',
    //             'C.office',
    //             'C.dob',
    //             'C.education',
    //             'C.occupation',
    //             'C.cast',
    //             'C.subCast',
    //             'C.addNote',
    //             'C.photo',
    //             'C.aadharNumber',
    //             'C.panNumber',
    //             'C.voterId',
    //             'C.rationCard',
    //             'C.assemblyId',
    //             'A.assemblyName',
    //             'C.cityType',
    //             'C.zillaParishadId',
    //             'C.talukaPanchayatId',
    //             'C.gaonId',
    //             'C.bjpVoter',
    //             'ZP.zillaParishadName',
    //             'TP.talukaPanchayatName',
    //             'G.gaonName',
    //             'W.wardName',
    //             'WA.wardAreaName',
    //             'C.created_by',
    //             'C.updated_by'
    //         )
    //         ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
    //         ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
    //         ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
    //         ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
    //         ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
    //         ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')

    //         ->where(function ($query) use ($contact, $aadhar) {
    //             $query->where('C.number', $contact)
    //                 ->orWhere('C.aadharNumber', $aadhar);
    //         })
    //         ->when($searchValue, function ($query) use ($searchValue) {
    //             $query->where(function ($query) use ($searchValue) {
    //                 $query->where('C.fname', 'like', '%' . $searchValue . '%')
    //                     ->orWhere('C.lname', 'like', '%' . $searchValue . '%')
    //                     ->orWhere('C.mname', 'like', '%' . $searchValue . '%');
    //             })->orWhere(function ($query) use ($searchValue) {
    //                 $searchValueParts = explode(' ', $searchValue);
    //                 $query->where(function ($query) use ($searchValueParts) {
    //                     $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%')
    //                         ->where('C.lname', 'like', '%' . end($searchValueParts) . '%');
    //                 })
    //                 ->orWhere(function ($query) use ($searchValueParts) {
    //                     $query->where('C.fname', 'like', '%' . end($searchValueParts) . '%')
    //                         ->where('C.lname', 'like', '%' . $searchValueParts[0] . '%');
    //                 })
    //                 ->orWhere(function ($query) use ($searchValueParts) {
    //                     $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%')
    //                         ->where('C.mname', 'like', '%' . end($searchValueParts) . '%');
    //                 })
    //                 ->orWhere(function ($query) use ($searchValueParts) {
    //                     $query->where('C.mname', 'like', '%' . $searchValueParts[0] . '%')
    //                         ->where('C.lname', 'like', '%' . end($searchValueParts) . '%');
    //                 });
    //             });
    //         });

    //         $data->orderBy('C.id', 'desc')
    //         ->selectRaw('ROW_NUMBER() OVER (ORDER BY C.id desc) AS RowNum');
            
    //     $count = $data->count();
    //   //  $limit = 25;
    //     $totalPage = ceil($count / $pageSize);

    //     $subquery = DB::table(DB::raw("({$data->toSql()}) as sub"))
    //         //->mergeBindings($data->getQuery()) // Use getQuery() to get the underlying Query\Builder
    //          ->mergeBindings($data)
    //         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);

    //     $data = $subquery->get();
    //     if (count($data) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $data,
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
    
    public function viewCitizenByContactNumberAndAadharNumberAndName($pageNo, $pageSize, $contact = null, $aadhar = null, $searchValue = null)
{
    $data = DB::table('citizens as C')
        ->select(
            'C.id as citizenId',
            'C.fname',
            'C.mname',
            'C.lname',
            'C.email',
            'C.gender',
            'C.number',
            'C.altNumber',
            'C.role',
            'C.office',
            'C.dob',
            'C.education',
            'C.occupation',
            'C.cast',
            'C.subCast',
            'C.addNote',
            'C.photo',
            'C.aadharNumber',
            'C.panNumber',
            'C.voterId',
            'C.rationCard',
            'C.assemblyId',
            'A.assemblyName',
            'C.cityType',
            'C.zillaParishadId',
            'C.talukaPanchayatId',
            'C.gaonId',
            'C.bjpVoter',
            'ZP.zillaParishadName',
            'TP.talukaPanchayatName',
            'G.gaonName',
            'W.wardName',
            'WA.wardAreaName',
            'C.created_by',
            'C.updated_by',
            'C.created_at'
        )
        ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
        ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
        ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
        ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
        ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
        ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
        ->where(function ($query) use ($contact, $aadhar) {
            $query->where('C.number', $contact)
                ->orWhere('C.aadharNumber', $aadhar);
        })
        ->when($searchValue, function ($query) use ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('C.fname', 'like', '%' . $searchValue . '%')
                    ->orWhere('C.lname', 'like', '%' . $searchValue . '%')
                    ->orWhere('C.mname', 'like', '%' . $searchValue . '%');
            })->orWhere(function ($query) use ($searchValue) {
                $searchValueParts = explode(' ', $searchValue);
                $query->where(function ($query) use ($searchValueParts) {
                    $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%')
                        ->where('C.lname', 'like', '%' . end($searchValueParts) . '%');
                })
                ->orWhere(function ($query) use ($searchValueParts) {
                    $query->where('C.lname', 'like', '%' . end($searchValueParts) . '%')
                        ->where('C.fname', 'like', '%' . $searchValueParts[0] . '%');
                })
                ->orWhere(function ($query) use ($searchValueParts) {
                    $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%')
                        ->where('C.mname', 'like', '%' . end($searchValueParts) . '%');
                })
                ->orWhere(function ($query) use ($searchValueParts) {
                    $query->where('C.mname', 'like', '%' . $searchValueParts[0] . '%')
                        ->where('C.lname', 'like', '%' . end($searchValueParts) . '%');
                })
                ->orWhere(function ($query) use ($searchValueParts) {
                    $query->where('C.fname', 'like', '%' . $searchValueParts[0] . '%');
                        
                })
                 ->orWhere(function ($query) use ($searchValueParts) {
                    $query->where('C.lname', 'like', '%' . $searchValueParts[0] . '%');
                        
                });
            });
        })
        ->orderBy('C.id', 'desc');

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

    
    
    
   
    public function getCitizenByRole($role)
    {
        $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $citizen = DB::table('citizens as C')->select(
            'C.id',
            'C.fname',
            'C.mname',
            'C.lname',
            'C.email',
            'C.gender',
            'C.number',
            'C.altNumber',
            'C.role',
            'C.office',
            'C.dob',
            'C.education',
            'C.occupation',
            'C.cast',
            'C.subCast',
            'C.addNote',
            'C.photo',
            'C.aadharNumber',
            'C.panNumber',
            'C.voterId',
            'C.rationCard',
            'C.assemblyId',
            DB::raw('A.assemblyName as AssemblyName'),
            'C.cityType',
            'C.zillaParishadId',
            DB::raw('ZP.zillaParishadName as zillaParishadName'),
            'C.talukaPanchayatId',
            DB::raw('TP.talukaPanchayatName as talukaPanchayatName'),
            'C.gaonId',
            DB::raw('G.gaonName as GaonName'),
            'C.wardId',
            DB::raw('W.wardName as WardName'),
            'C.wardAreaId',
            DB::raw('WA.wardAreaName as WardAreaName'),
            'C.pincode',
            'C.add1',
            'C.add2',
            'C.nativePlace',
            'C.accNo',
            'C.partNo',
            'C.sectionNumber',
            'C.slnNumberInPart',
            'C.bjpVoter',
            'C.created_by',
            'C.updated_by'
        )
            ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('zilla_parishads as ZP', 'ZP.id', '=', 'C.zillaParishadId')
            ->leftJoin('taluka_panchayats as TP', 'TP.id', '=', 'C.talukaPanchayatId')
            ->leftJoin('gaon as G', 'G.id', '=', 'C.gaonId')
            ->leftJoin('ward as W', 'W.id', '=', 'C.wardId')
            ->leftJoin('wardArea as WA', 'WA.id', '=', 'C.wardAreaId')
            ->where('C.role', $role)
            ->get();

        foreach ($citizen as $item) {
            $res = [
                'id' => $item->id,
                'fname' => $item->fname,
                'mname' => $item->mname,
                'lname' => $item->lname,
                'email' => $item->email,
                'gender' => $item->gender,
                'number' => $item->number,
                'altNumber' => $item->altNumber,
                'role' => $item->role,
                'office' => $item->office,
                'dob' => $item->dob,
                'education' => $item->education,
                'occupation' => $item->occupation,
                'cast' => $item->cast,
                'subCast' => $item->subCast,
                'addNote' => $item->addNote,
                'photo' => $path . $item->photo,
                'aadharNumber' => $item->aadharNumber,
                'panNumber' => $item->panNumber,
                'voterId' => $item->voterId,
                'rationCard' => $item->rationCard,
                'AssemblyName' => $item->AssemblyName,
                'cityType' => $item->cityType,
                'zillaParishadName' => $item->zillaParishadName,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'GaonName' => $item->GaonName,
                'WardName' => $item->WardName,
                'WardAreaName' => $item->WardAreaName,
                'pincode' => $item->pincode,
                'add1' => $item->add1,
                'add2' => $item->add2,
                'nativePlace' => $item->nativePlace,
                'accNo' => $item->accNo,
                'partNo' => $item->partNo,
                'sectionNumber' => $item->sectionNumber,
                'slnNumberInPart' => $item->slnNumberInPart,
                'bjpVoter' => $item->bjpVoter,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $results[] = $res;
        }
        if (count($citizen) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $results,
                'message' => 'CitizenFetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Citizen Not Found',
            ]);
        }
    }

    public function getCitienByGaonId($gaonId)
    {
        $citizens = DB::table('citizens as C')
            ->select('C.id', 'C.fname', 'C.number', 'C.occupation', 'C.add1')
            ->where('C.gaonId', $gaonId)
            ->get();
        if (count($citizens) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $citizens,
                'message' => 'Citizen Fetched',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Citizen Not Found',
            ]);
        }
    }

    public function viewAll()
    {
        $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $data = DB::table('citizens as C')
            ->select(
                'C.id',
                'C.fname',
                'C.mname',
                'C.lname',
                'C.email',
                'C.gender',
                'C.number',
                'C.altNumber',
                'C.role',
                'C.office',
                'C.dob',
                'C.education',
                'C.occupation',
                'C.cast',
                'C.subCast',
                'C.addNote',
                'C.photo',
                'C.aadharNumber',
                'C.panNumber',
                'C.voterId',
                'C.rationCard',
                'C.assemblyId',
                'A.assemblyName',
                'C.cityType',
                'C.zillaParishadId',
                'C.talukaPanchayatId',
                'C.gaonId',
                'C.bjpVoter',
                'ZP.zillaParishadName',
                'TP.talukaPanchayatName',
                'G.gaonName',
                'W.wardName',
                'WA.wardAreaName',
                'C.pincode',
                'C.add1',
                'C.add2',
                'C.nativePlace',
                'C.accNo',
                'C.partNo',
                'C.sectionNumber',
                'C.slnNumberInPart',
                'C.created_by',
                'C.updated_by'
            )
            ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
            ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
            ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
            ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
            ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
            ->orderBy('C.id', 'desc')
            ->get();
        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'fname' => $item->fname,
                'mname' => $item->mname,
                'lname' => $item->lname,
                'email' => $item->email,
                'gender' => $item->gender,
                'number' => $item->number,
                'altNumber' => $item->altNumber,
                'role' => $item->role,
                'office' => $item->office,
                'dob' => $item->dob,
                'education' => $item->education,
                'occupation' => $item->occupation,
                'cast' => $item->cast,
                'subCast' => $item->subCast,
                'addNote' => $item->addNote,
                'photo' => $path . $item->photo,
                'aadharNumber' => $item->aadharNumber,
                'panNumber' => $item->panNumber,
                'voterId' => $item->voterId,
                'rationCard' => $item->rationCard,
                'assemblyId' => $item->assemblyId,
                'assemblyName' => $item->assemblyName,
                'cityType' => $item->cityType,
                'zillaParishadId' => $item->zillaParishadId,
                'talukaPanchayatId' => $item->talukaPanchayatId,
                'gaonId' => $item->gaonId,
                'zillaParishadName' => $item->zillaParishadName,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'gaonName' => $item->gaonName,
                'wardName' => $item->wardName,
                'wardAreaName' => $item->wardAreaName,
                'bjpVoter' => $item->bjpVoter,
                'pincode' => $item->pincode,
                'add1' => $item->add1,
                'add2' => $item->add2,
                'nativePlace' => $item->nativePlace,
                'accNo' => $item->accNo,
                'partNo' => $item->partNo,
                'sectionNumber' => $item->sectionNumber,
                'slnNumberInPart' => $item->slnNumberInPart,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by,
            ];
            $results[] = $res;
        }
        // 'C.pincode','C.add1','C.add2','C.nativePlace','C.accNo','C.partNo','C.sectionNumber','C.slnNumberInPart',
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

    public function viewPaginate()
    {
        $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $data = DB::table('citizens as C')
            ->select(
                'C.id',
                'C.fname',
                'C.mname',
                'C.lname',
                'C.email',
                'C.gender',
                'C.number',
                'C.altNumber',
                'C.role',
                'C.office',
                'C.dob',
                'C.education',
                'C.occupation',
                'C.cast',
                'C.subCast',
                'C.addNote',
                'C.photo',
                'C.aadharNumber',
                'C.panNumber',
                'C.voterId',
                'C.rationCard',
                'C.assemblyId',
                'A.assemblyName',
                'C.cityType',
                'C.zillaParishadId',
                'C.talukaPanchayatId',
                'C.gaonId',
                'C.bjpVoter',
                'ZP.zillaParishadName',
                'TP.talukaPanchayatName',
                'G.gaonName',
                'W.wardName',
                'WA.wardAreaName',
                'C.pincode',
                'C.add1',
                'C.add2',
                'C.nativePlace',
                'C.accNo',
                'C.partNo',
                'C.sectionNumber',
                'C.slnNumberInPart',
                'C.created_by',
                'C.updated_by'
            )
            ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
            ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
            ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
            ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
            ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
            ->paginate(5);
        foreach ($data as $item) {
            $res = [
                'id' => $item->id,
                'fname' => $item->fname,
                'mname' => $item->mname,
                'lname' => $item->lname,
                'email' => $item->email,
                'gender' => $item->gender,
                'number' => $item->number,
                'altNumber' => $item->altNumber,
                'role' => $item->role,
                'office' => $item->office,
                'dob' => $item->dob,
                'education' => $item->education,
                'occupation' => $item->occupation,
                'cast' => $item->cast,
                'subCast' => $item->subCast,
                'addNote' => $item->addNote,
                'photo' => $path . $item->photo,
                'aadharNumber' => $item->aadharNumber,
                'panNumber' => $item->panNumber,
                'voterId' => $item->voterId,
                'rationCard' => $item->rationCard,
                'assemblyId' => $item->assemblyId,
                'assemblyName' => $item->assemblyName,
                'cityType' => $item->cityType,
                'zillaParishadId' => $item->zillaParishadId,
                'talukaPanchayatId' => $item->talukaPanchayatId,
                'gaonId' => $item->gaonId,
                'zillaParishadName' => $item->zillaParishadName,
                'talukaPanchayatName' => $item->talukaPanchayatName,
                'gaonName' => $item->gaonName,
                'wardName' => $item->wardName,
                'wardAreaName' => $item->wardAreaName,
                'bjpVoter' => $item->bjpVoter,
                'pincode' => $item->pincode,
                'add1' => $item->add1,
                'add2' => $item->add2,
                'nativePlace' => $item->nativePlace,
                'accNo' => $item->accNo,
                'partNo' => $item->partNo,
                'sectionNumber' => $item->sectionNumber,
                'slnNumberInPart' => $item->slnNumberInPart,
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

    public function viewCitizenById($id)
    {
        $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $data = DB::table('citizens as C')
            ->select(
                'C.id',
                'C.fname',
                'C.mname',
                'C.lname',
                'C.email',
                'C.gender',
                'C.number',
                'C.altNumber',
                'C.role',
                'C.office',
                'C.dob',
                'C.education',
                'C.occupation',
                'C.cast',
                'C.subCast',
                'C.addNote',
                'C.photo',
                 DB::raw("CONCAT('$path', C.photo) AS Photopath"),
                'C.aadharNumber',
                'C.panNumber',
                'C.voterId',
                'C.rationCard',
                'C.assemblyId',
                'A.assemblyName',
                'C.cityType',
                'C.zillaParishadId',
                'C.talukaPanchayatId',
                'C.gaonId',
                'C.bjpVoter',
                'ZP.zillaParishadName',
                'TP.talukaPanchayatName',
                'G.gaonName',
                'W.wardName',
                'WA.wardAreaName',
                'C.pincode',
                'C.add1',
                'C.add2',
                'C.nativePlace',
                'C.accNo',
                'C.partNo',
                'C.sectionNumber',
                'C.slnNumberInPart',
                'C.created_by',
                'C.updated_by'
            )
            ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
            ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
            ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
            ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
            ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
            ->where('C.id', $id)
            ->first();
        // foreach ($data as $item) {
        //     $res = [
        //         'id' => $item->id,
        //         'fname' => $item->fname,
        //         'mname' => $item->mname,
        //         'lname' => $item->lname,
        //         'email' => $item->email,
        //         'gender' => $item->gender,
        //         'number' => $item->number,
        //         'altNumber' => $item->altNumber,
        //         'role' => $item->role,
        //         'office' => $item->office,
        //         'dob' => $item->dob,
        //         'education' => $item->education,
        //         'occupation' => $item->occupation,
        //         'cast' => $item->cast,
        //         'subCast' => $item->subCast,
        //         'addNote' => $item->addNote,
        //         'photo' => $path . $item->photo,
        //         'aadharNumber' => $item->aadharNumber,
        //         'panNumber' => $item->panNumber,
        //         'voterId' => $item->voterId,
        //         'rationCard' => $item->rationCard,
        //         'assemblyId' => $item->assemblyId,
        //         'assemblyName' => $item->assemblyName,
        //         'cityType' => $item->cityType,
        //         'zillaParishadId' => $item->zillaParishadId,
        //         'talukaPanchayatId' => $item->talukaPanchayatId,
        //         'gaonId' => $item->gaonId,
        //         'zillaParishadName' => $item->zillaParishadName,
        //         'talukaPanchayatName' => $item->talukaPanchayatName,
        //         'gaonName' => $item->gaonName,
        //         'wardName' => $item->wardName,
        //         'wardAreaName' => $item->wardAreaName,
        //         'bjpVoter' => $item->bjpVoter,
        //     ];
        //     $results[] = $res;
        // }
        if ($data) {
            return response()->json([
                'code' => 200,
                'data' => $data,
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

    /*public function ViewAllByPagination($pageNo)
    {
        // $results = DB::table('citizens AS C')
        //     ->select('C.id', 'C.fname', 'C.mname', 'C.lname', 'C.email', 'C.gender', 'C.number', 'C.altNumber', 'C.role', 'C.office', 'C.dob', 'C.education', 'C.occupation', 'C.cast', 'C.subCast', 'C.addNote', 'C.photo', 'C.aadharNumber', 'C.panNumber', 'C.voterId', 'C.rationCard', 'C.assemblyId', 'A.assemblyName', 'C.cityType', 'C.zillaParishadId', 'C.talukaPanchayatId', 'C.gaonId', 'C.bjpVoter', 'ZP.zillaParishadName', 'TP.talukaPanchayatName', 'G.gaonName', 'W.wardName', 'WA.wardAreaName')
        //     ->leftJoin('zilla_parishads AS ZP', 'C.zillaParishadId', '=', 'ZP.id')
        //     ->leftJoin('taluka_panchayats AS TP', 'C.talukaPanchayatId', '=', 'TP.id')
        //     ->leftJoin('gaon AS G', 'C.gaonId', '=', 'G.id')
        //     ->leftJoin('ward AS W', 'C.wardId', '=', 'W.id')
        //     ->leftJoin('assembly AS A', 'A.id', '=', 'C.assemblyId')
        //     ->leftJoin('wardArea AS WA', 'C.wardAreaId', '=', 'WA.id')
        //     ->orderBy('C.id')
        //     ->selectRaw('ROW_NUMBER() OVER (ORDER BY C.id) AS RowNum')
        //     ->whereBetween(DB::raw('RowNum'), [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize])
        //     ->get();

        $count = User::count();
        $limit = 25;
        $totalPage = ceil($count / $limit);
        $results = DB::table('citizens AS C')
            ->select('C.id', 'C.fname', 'C.mname', 'C.lname', 'C.email', 'C.gender', 'C.number', 'C.altNumber', 'C.role', 'C.office', 'C.dob', 'C.education', 'C.occupation', 'C.cast', 'C.subCast', 'C.addNote', 'C.photo', 'C.aadharNumber', 'C.panNumber', 'C.voterId', 'C.rationCard', 'C.assemblyId', 'A.assemblyName', 'C.cityType', 'C.zillaParishadId', 'C.talukaPanchayatId', 'C.gaonId', 'C.bjpVoter', 'ZP.zillaParishadName', 'TP.talukaPanchayatName', 'G.gaonName', 'W.wardName', 'WA.wardAreaName', 'C.pincode', 'C.add1', 'C.add2', 'C.nativePlace', 'C.accNo', 'C.partNo', 'C.sectionNumber', 'C.slnNumberInPart', 'C.created_by', 'C.updated_by')
            ->leftJoin('zilla_parishads AS ZP', 'C.zillaParishadId', '=', 'ZP.id')
            ->leftJoin('taluka_panchayats AS TP', 'C.talukaPanchayatId', '=', 'TP.id')
            ->leftJoin('gaon AS G', 'C.gaonId', '=', 'G.id')
            ->leftJoin('ward AS W', 'C.wardId', '=', 'W.id')
            ->leftJoin('assembly AS A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('wardArea AS WA', 'C.wardAreaId', '=', 'WA.id')
            // ->orderBy('C.id')
            ->selectRaw('ROW_NUMBER() OVER (ORDER BY C.id desc) AS RowNum')
            ->orderBy('C.id', 'desc');

        $subquery = DB::table(DB::raw("({$results->toSql()}) as sub"))
            ->mergeBindings($results)
            ->whereBetween('RowNum', [($pageNo - 1) * $limit + 1, $pageNo * $limit]);

        $results = $subquery->get();

        return response()->json([
            'code' => 200,
            'data' => $results,
            'count' => $count,
            'Total Page' => $totalPage,
            'message' => 'Data Fetched',
        ]);
    }*/

    //Vipul

    //  public function ViewAllByPagination($pageNo, $pageSize, $contact = null, $aadhar = null, $fname = null, $role = null)
    // {
    //     $results = DB::table('citizens AS C')
    //         ->select('C.id', 'C.fname', 'C.mname', 'C.lname', 'C.email', 'C.gender', 'C.number', 'C.altNumber', 'C.role', 'C.office', 'C.dob', 'C.education', 'C.occupation', 'C.cast', 'C.subCast', 'C.addNote', 'C.photo', 'C.aadharNumber', 'C.panNumber', 'C.voterId', 'C.rationCard', 'C.assemblyId', 'A.assemblyName', 'C.cityType', 'C.zillaParishadId', 'C.talukaPanchayatId', 'C.gaonId', 'C.bjpVoter', 'ZP.zillaParishadName', 'TP.talukaPanchayatName', 'G.gaonName', 'W.wardName', 'WA.wardAreaName', 'C.pincode', 'C.add1', 'C.add2', 'C.nativePlace', 'C.accNo', 'C.partNo', 'C.sectionNumber', 'C.slnNumberInPart', 'C.created_by', 'C.updated_by')
    //         ->leftJoin('zilla_parishads AS ZP', 'C.zillaParishadId', '=', 'ZP.id')
    //         ->leftJoin('taluka_panchayats AS TP', 'C.talukaPanchayatId', '=', 'TP.id')
    //         ->leftJoin('gaon AS G', 'C.gaonId', '=', 'G.id')
    //         ->leftJoin('ward AS W', 'C.wardId', '=', 'W.id')
    //         ->leftJoin('assembly AS A', 'A.id', '=', 'C.assemblyId')
    //         ->leftJoin('wardArea AS WA', 'C.wardAreaId', '=', 'WA.id');
    //         if ($contact) {
    //             $results->where('C.number', $contact);
    //         }

    //         if ($aadhar) {
    //              $results->where('C.aadharNumber', $aadhar);
    //          }
    //         if ($fname) {
    //              $results->where('C.fname', $fname);
    //          }
    //           if ($role) {
    //              $results->where('C.role', $role);
    //          }
    //          $results->orderBy('C.id', 'desc')
    //         ->selectRaw('ROW_NUMBER() OVER (ORDER BY C.id desc) AS RowNum');

    //     $count = $results->count();
    //     $totalPage = ceil($count / $pageSize);
    //     $subquery = DB::table(DB::raw("({$results->toSql()}) as sub"))
    //         ->mergeBindings($results)
    //         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);

    //         $results = $subquery->get();
    //     if (count($results) != 0) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $results,
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
    
    public function ViewAllByPagination($pageNo, $pageSize, $contact = null, $aadhar = null, $fname = null, $role = null)
{
    $results = DB::table('citizens AS C')
        ->select('C.id', 'C.fname', 'C.mname', 'C.lname', 'C.email', 'C.gender', 'C.number', 'C.altNumber', 'C.role', 'C.office', 'C.dob', 'C.education', 'C.occupation', 'C.cast', 'C.subCast', 'C.addNote', 'C.photo', 'C.aadharNumber', 'C.panNumber', 'C.voterId', 'C.rationCard', 'C.assemblyId', 'A.assemblyName', 'C.cityType', 'C.zillaParishadId', 'C.talukaPanchayatId', 'C.gaonId', 'C.bjpVoter', 'ZP.zillaParishadName', 'TP.talukaPanchayatName', 'G.gaonName', 'W.wardName', 'WA.wardAreaName', 'C.pincode', 'C.add1', 'C.add2', 'C.nativePlace', 'C.accNo', 'C.partNo', 'C.sectionNumber', 'C.slnNumberInPart', 'C.created_by', 'C.updated_by')
        ->leftJoin('zilla_parishads AS ZP', 'C.zillaParishadId', '=', 'ZP.id')
        ->leftJoin('taluka_panchayats AS TP', 'C.talukaPanchayatId', '=', 'TP.id')
        ->leftJoin('gaon AS G', 'C.gaonId', '=', 'G.id')
        ->leftJoin('ward AS W', 'C.wardId', '=', 'W.id')
        ->leftJoin('assembly AS A', 'A.id', '=', 'C.assemblyId')
        ->leftJoin('wardArea AS WA', 'C.wardAreaId', '=', 'WA.id');

    if ($contact) {
        $results->where('C.number', $contact);
    }

    if ($aadhar) {
        $results->where('C.aadharNumber', $aadhar);
    }

    if ($fname) {
        $results->where('C.fname', $fname);
    }

    if ($role) {
        $results->where('C.role', $role);
    }

    $count = $results->count();
    $totalPage = ceil($count / $pageSize);

    $results = $results
        ->offset(($pageNo - 1) * $pageSize)
        ->limit($pageSize)
        ->orderBy('C.id', 'desc')
        ->get();

    if (count($results) != 0) {
        return response()->json([
            'code' => 200,
            'data' => $results,
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





    public function viewKaryakartaCount()
    {
        $Karyakarta = User::where('citizens.role', 'Karyakarta')->count();
        if ($Karyakarta) {
            return response()->json([
                'code' => 200,
                'data' => $Karyakarta,
                'message' => 'Karyakarta Count Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Karyakarta Not Found',
            ]);
        }
    }

    public function todaysBirthday($todayDate)
    {
       // $today = now();
       $today = date("Y-m-d", strtotime($todayDate));
        // $today = new DateTime($todayDate);
        $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $data = DB::table('citizens as C')
            ->select(
                'C.id',
                'C.fname',
                'C.mname',
                'C.lname',
                'C.email',
                'C.gender',
                'C.number',
                'C.altNumber',
                'C.role',
                'C.office',
                'C.dob',
                'C.education',
                'C.occupation',
                'C.cast',
                'C.subCast',
                'C.addNote',
                'C.photo',
                // ($path . 'C.photo') AS Photopath,
                 DB::raw("CONCAT('$path', C.photo) AS Photopath"),
                'C.aadharNumber',
                'C.panNumber',
                'C.voterId',
                'C.rationCard',
                'C.assemblyId',
                'A.assemblyName',
                'C.cityType',
                'C.zillaParishadId',
                'C.talukaPanchayatId',
                'C.gaonId',
                'C.bjpVoter',
                'ZP.zillaParishadName',
                'TP.talukaPanchayatName',
                'G.gaonName',
                'W.wardName',
                'WA.wardAreaName',
                'C.pincode',
                'C.add1',
                'C.add2',
                'C.nativePlace',
                'C.accNo',
                'C.partNo',
                'C.sectionNumber',
                'C.slnNumberInPart',
                'C.created_by'


            )
            ->leftJoin('zilla_parishads as ZP', 'C.zillaParishadId', '=', 'ZP.id')
            ->leftJoin('taluka_panchayats as TP', 'C.talukaPanchayatId', '=', 'TP.id')
            ->leftJoin('gaon as G', 'C.gaonId', '=', 'G.id')
            ->leftJoin('ward as W', 'C.wardId', '=', 'W.id')
            ->leftJoin('assembly as A', 'A.id', '=', 'C.assemblyId')
            ->leftJoin('wardArea as WA', 'C.wardAreaId', '=', 'WA.id')
            ->whereMonth('C.dob', Carbon::parse($todayDate)->month)
            ->whereDay('C.dob', Carbon::parse($todayDate)->day)
            ->get();
        // 2023-10-01

        $Adhikaris = Adhikari::select('adhikari.id as adhikariId', 'adhikari.firstName', 'adhikari.middleName', 'adhikari.lastName', 'adhikari.gender', 'adhikari.mobileNo', 'adhikari.alternateNo', 'adhikari.departmentId', 'departments.departmentName', 'adhikari.designation', 'adhikari.education', 'adhikari.dateOfBirth', 'adhikari.address', 'adhikari.photo', 'adhikari.created_by', 'adhikari.updated_by')
            ->leftjoin('departments', 'adhikari.departmentId', 'departments.id')
            ->whereMonth('adhikari.dateOfBirth', Carbon::parse($todayDate)->month)
            ->whereDay('adhikari.dateOfBirth', Carbon::parse($todayDate)->day)
            ->get();
        // 2023-10-20
        if ($Adhikaris) {
            foreach ($Adhikaris as $Adhikari) {
                $res = [
                    'adhikariId' => $Adhikari->adhikariId,
                    'firstName' => $Adhikari->firstName,
                    'middleName' => $Adhikari->middleName,
                    'lastName' => $Adhikari->lastName,
                    'gender' => $Adhikari->gender,
                    'mobileNo' => $Adhikari->mobileNo,
                    'alternateNo' => $Adhikari->alternateNo,
                    'departmentId' => $Adhikari->departmentId,
                    'departmentName' => $Adhikari->departmentName,
                    'dateOfBirth' => $Adhikari->dateOfBirth,
                    'designation' => $Adhikari->designation,
                    'education' => $Adhikari->education,
                    'address' => $Adhikari->address,
                    'photo' => $Adhikari->photo,
                    'photopath' => 'https://mlaapi.orisunlifescience.coms/public/AdhikariPhoto/' . $Adhikari->photo,
                    'created_by' => $Adhikari->created_by,
                    'updated_by' => $Adhikari->updated_by,
                ];
                $result[] = $res;
            }
        }else{
            $result = null;
        }

        if ($data || $Adhikaris) {
            return response()->json([
                'code' => 200,
                'data' => count($data)!=0 ? $data : [],
                'adhikari' => count($Adhikaris)!=0 ? $result : [],
                // 'totalCount' =>(count($data)!=0 ? $data : 0) + (count($Adhikaris)!=0 ? $result : 0),
                'message' => 'Data Fetched Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Found',
            ]);
        }
    }


}
