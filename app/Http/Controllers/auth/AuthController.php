<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\Permission;
use App\Models\ComplaintDetails;
use App\Models\Images;
use App\Models\Invitation;
use App\Models\Register;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\IsNull;
use SebastianBergmann\Type\NullType;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{
    public function _construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'fname' => 'required',
            'mname' => '',
            'lname' => 'required',
            'role' => 'required',
            'office' => 'required',
            'number' => 'required|string|unique:citizens',
            'password' => 'required|string|min:3',
            'visiblePassword' => 'required|string|min:3',
            'email' => '',
            'gender' => '',
            'altNumber' => '',
            'dob' => '',
            'education'  => '',
            'occupation'  => '',
            'cast' => '',
            'subCast' => '',
            'addNote'  => '',
            'photo' => '',
            'aadharNumber' => '',
            'panNumber' => '',
            'voterId' => '',
            'rationCard' => '',
            'assemblyId' => '',
            'cityType' => '',
            'zillaParishadId'  => '',
            'talukaPanchayatId'  => '',
            'gaonId'  => '',
            'wardId'  => '',
            'wardAreaId'  => '',
            'pincode' => '',
            'add1'  => '',
            'add2'  => '',
            'nativePlace'  => '',
            'accNo' => '',
            'partNo' => '',
            'sectionNumber' => '',
            'slnNumberInPart' => '',
            'bjpVoter' => '',
            'userId' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $user = User::create(
        //     array_merge(
        //         $Validator->validated(),
        //         ['password' => bcrypt($request->password)],
        //         ['visiblePassword' => $request->password]
        //     )
        // );
        $user = new User();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->role = $request->role;
        $user->office = $request->office;
        $user->number = $request->number;
        $user->password = $request->password;
        $user->visiblePassword = $request->visiblePassword;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->altNumber = $request->altNumber;
        $user->dob = $request->dob;
        $user->education = $request->education;
        $user->occupation = $request->occupation;
        $user->cast = $request->cast;
        $user->subCast = $request->subCast;
        $user->addNote = $request->addNote;
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
        $user->created_by = $request->userId;
        // $user->photo = $request->photo;
        // if($request->photo)
        // $image='';
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $fileName = $request->file('photo');
            $documentName = str_replace(' ', '_', $fileName->getClientOriginalName());
            $name = pathinfo($documentName, PATHINFO_FILENAME);
            $new_name = $name . date('YmdHis') . '.' . $fileName->getClientOriginalExtension();
            $path = $fileName->move(public_path('/Photo'), $new_name);
            $user->photo = $new_name;
        }
        $user->save();
        if ($user) {
            return response()->json([
                'message' => 'user registered sucecssfully',
                'user' => $user,
            ], 201);
        } else {
            return response()->json([
                'message' => 'user not registered',
                'user' => [],
                'permission' => [],
            ], 401);
        }
        // return response()->json([
        //     'message' => 'user registered sucecssfully',
        //     'user' => $user,
        // ], 201);
    }

    public function apitokencheck(Request $request)
    {

        return json_encode(\Auth::user());
    }

    public function login(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required|string|min:3',
        ]);
        // print_r($Validator);

        if ($Validator->fails()) {
            return response()->json($Validator->errors(), 422);
        }
        if (!$token = JWTAuth::attempt($Validator->validated())) {
            return response()->json(["error" => "Unauthorized"], 401);
        }

        return $this->createNewToken($token);
    }

    // fname,mname,lname,email,gender,number,altNumber,password,visiblePassword,role,office,dob,education,occupation,cast,subCast,addNote,photo,aadharNumber,panNumber,voterId,rationCard,assemblyId,cityType,zillaParishadId,talukaPanchayatId,gaonId,wardId,wardAreaId,pincode,add1,add2,nativePlace,accNo,partNo,sectionNumber,slnNumberInPart,bjpVoter,
    public function createNewToken($token)
    {
        $User = Auth::user();
        // $User = User::select('citizens.id as userId', 'citizens.fname', 'citizens.mname', 'citizens.lname', 'citizens.email', 'citizens.gender', 'citizens.number', 'citizens.altNumber', 'citizens.password', 'citizens.visiblePassword', 'citizens.role', 'citizens.office', 'citizens.dob', 'citizens.education', 'citizens.occupation', 'citizens.cast', 'citizens.subCast', 'citizens.addNote', 'citizens.photo', 'citizens.aadharNumber', 'citizens.panNumber', 'citizens.voterId', 'citizens.rationCard', 'citizens.assemblyId', 'citizens.cityType', 'citizens.zillaParishadId', 'citizens.talukaPanchayatId', 'citizens.gaonId', 'citizens.wardId', 'citizens.wardAreaId', 'citizens.pincode', 'citizens.add1', 'citizens.add2', 'citizens.nativePlace', 'citizens.accNo', 'citizens.partNo', 'citizens.sectionNumber', 'citizens.slnNumberInPart', 'citizens.bjpVoter')->where('citizens.id', $User['id'])->get();

        // $Permission = UserPermission::select('userPermission.userId','userPermission.permissionId','permissions.permission')->leftjoin('permissions', 'userPermission.permissionId', '=', 'permissions.id')->where('userPermission.userId', $User['id'])->get();

        $Permissions = Permission::select('permissions.id as permissionId', 'permissions.permission', 'permissions.created_by', 'permissions.updated_by')->get();

        foreach ($Permissions as $permission) {
            $ischecked = UserPermission::where('userPermission.permissionId', $permission->permissionId)->where('userPermission.userId', $User['id'])->get();
            $res = [
                'permissionId' => $permission->permissionId,
                'permission' => $permission->permission,
                'ischecked' => count($ischecked) != 0 ? 'true' : 'false',
                'created_by' => $permission->created_by,
                'updated_by' => $permission->updated_by,
            ];


            $result[] = $res;
        }
        if ($token) {
            return response()->json([
                "code" => 200,
                'accessToken' => $token,
                'tokenType' => 'bearer',
                "data" => $User,
                "userPermission" => $result,
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                // 'expiresIn' =>auth()->factory()->getTTL() * 60 * 24 * 1,
                "message" => "Login Successfully"
            ], 200);
        } else {
            return response()->json([
                "code" => 404,
                "data" => [],
                'message' => 'Not Found'
            ], 404);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }

    //View All users
    public function index()
    {
        $User = User::all();
        return response()->json(['User' => $User], 200);
        //return response()->json(auth()->user());
    }

    public function update(Request $request, $id)
    {
        $Validator = Validator::make($request->validated(), [
            'name' => 'required',
            'email' => 'required|string |unique:users',
            'password' => 'required|string|confirmed|min:3',
        ]);

        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        // $user = User::create(
        //     array_merge(
        //         $Validator->validated(),
        //         ['password' => bcrypt($request->password)],
        //         ['visiblePassword' => $request->password]
        //     )
        // );

        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  bcrypt($request->password);
            $user->visiblePassword = $request->password;
            $user->update();

            return response()->json([
                'message' => 'user Updated Successfully',
                'user' => $user,
            ], 200);
        } else {
            return response()->json(['message' => 'user Not found'], 404);
        }
    }

    // Refesh Token
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    // Logout
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'user logged out',
        ]);
    }


    public function viewAllRegisters()
    {
        $users = DB::table('citizens')
            // ->where('id', '=', 6)
            ->select('id', 'fname', 'lname', 'number', 'role', 'office')
            ->whereNotNull('visiblePassword')
            ->orderBy('id', 'desc')
            ->get();
        if (count($users) != 0) {
            return response()->json([
                'code' => 200,
                'data' => $users,
                'message' => 'Data Fetched'
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Fetched'
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
            'userId' => 'required',
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
            $user->created_by = $request->userId;
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

    public function ViewRegisterById($id)
    {
        $users = DB::table('citizens as c')->select('c.id', 'c.fname', 'c.mname', 'c.lname', 'c.email', 'c.gender', 'c.number', 'c.altNumber', 'c.password','c.visiblePassword', 'c.role', 'c.office', 'c.dob', 'c.education', 'c.occupation', 'c.cast', 'c.subCast', 'c.addNote', 'c.photo', 'c.aadharNumber', 'c.panNumber', 'c.voterId', 'c.rationCard', 'c.assemblyId', 'a.assemblyName', 'c.cityType', 'c.zillaParishadId', 'zp.zillaParishadName', 'c.talukaPanchayatId', 'tp.talukaPanchayatName', 'c.gaonId', 'g.gaonName', 'c.wardId', 'w.wardName', 'c.wardAreaId', 'wa.wardAreaName', 'c.pincode', 'c.add1', 'c.add2', 'c.nativePlace', 'c.accNo', 'c.partNo', 'c.sectionNumber', 'c.slnNumberInPart', 'c.bjpVoter', 'c.created_by', 'c.updated_by')
            ->leftjoin('gaon as g', 'c.gaonId', 'g.id')
            ->leftjoin('ward as w', 'c.wardId', 'w.id')
            ->leftjoin('wardArea as wa', 'c.wardAreaId', 'wa.id')
            ->leftjoin('taluka_panchayats as tp', 'c.talukaPanchayatId', 'tp.id')
            ->leftjoin('assembly as a', 'c.assemblyId', 'a.id')
            ->leftjoin('zilla_parishads as zp', 'c.zillaParishadId', 'zp.id')
            ->where('c.id', '=', $id)
            // ->whereNotNull('c.visiblePassword')
            ->get();

        $ComplaintCount=ComplaintDetails::where('complaint_details.complainerId',$id)->count();
        $InvitationInviterCount=Invitation::where('invitations.inviterId',$id)->count();
        $InvitationReferenceCount=Invitation::where('invitations.referenceId',$id)->count();
        $RegisterDocumentFromCount=Register::where('register.documentFrom',$id)->count();
        $RegisterDeliveredByCount=Register::where('register.deliveredBy',$id)->count();
        $RegisterDocumentForCount=Register::where('register.documentFor',$id)->count();
        $RegisterReceivedByCount=Register::where('register.receivedBy',$id)->count();
            if ($users) {
            foreach ($users as $user) {
                if($user->photo==Null){
                    $photo=Null;
                }else{
                    $photo='image';
                }
                $res = [
                    'id' => $user->id,
                    'fname' => $user->fname,
                    'mname' => $user->mname,
                    'lname' => $user->lname,
                    'email' => $user->email,
                    'gender' => $user->gender,
                    'number' => $user->number,
                    'altNumber' => $user->altNumber,
                    'password' => $user->password,
                    'visiblePassword' => $user->visiblePassword,
                    'role' => $user->role,
                    'office' => $user->office,
                    'dob' => $user->dob,
                    'education' => $user->education,
                    'occupation' => $user->occupation,
                    'cast' => $user->cast,
                    'subCast' => $user->subCast,
                    'addNote' => $user->addNote,
                    'test' => isEmpty($user->photo) ? Null : 'image',
                    'photo' => ($user->photo==Null) ? 'user-vector.jpg' : $user->photo,
                    // 'photo' => IsEmpty($user->photo) ? 'user-vector.jpg' : $user->photo,
                    'photoPath' => ($user->photo==Null) ? ( 'https://mlaapi.sapnakabraart.com/public/Photo/user-vector.jpg') : ( 'https://mlaapi.sapnakabraart.com/public/Photo/' . $user->photo),
                    'aadharNumber' => $user->aadharNumber,
                    'panNumber' => $user->panNumber,
                    'voterId' => $user->voterId,
                    'rationCard' => $user->rationCard,
                    'assemblyId' => $user->assemblyId,
                    'assemblyName' => $user->assemblyName,
                    'cityType' => $user->cityType,
                    'zillaParishadId' => $user->zillaParishadId,
                    'zillaParishadName' => $user->zillaParishadName,
                    'talukaPanchayatId' => $user->talukaPanchayatId,
                    'talukaPanchayatName' => $user->talukaPanchayatName,
                    'gaonId' => $user->gaonId,
                    'gaonName' => $user->gaonName,
                    'wardId' => $user->wardId,
                    'wardName' => $user->wardName,
                    'wardAreaId' => $user->wardAreaId,
                    'wardAreaName' => $user->wardAreaName,
                    'pincode' => $user->pincode,
                    'add1' => $user->add1,
                    'add2' => $user->add2,
                    'nativePlace' => $user->nativePlace,
                    'accNo' => $user->accNo,
                    'partNo' => $user->partNo,
                    'sectionNumber' => $user->sectionNumber,
                    'slnNumberInPart' => $user->slnNumberInPart,
                    'bjpVoter' => $user->bjpVoter,
                    'created_by' => $user->created_by,
                    'updated_by' => $user->updated_by,
                    'complaintCount' => $ComplaintCount,
                    'invitationInviterCount' => $InvitationInviterCount,
                    'invitationReferenceCount' => $InvitationReferenceCount,
                    'registerDocumentFromCount' => $RegisterDocumentFromCount,
                    'registerDeliveredByCount' => $RegisterDeliveredByCount,
                    'registerDocumentForCount' => $RegisterDocumentForCount,
                    'registerReceivedByCount' => $RegisterReceivedByCount,
                ];
                $result[] = $res;
            }
        }
        if ($users) {
            return response()->json([
                'code' => 200,
                'data' => $result[0],
                'message' => 'Data Fetched'
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Data Not Fetched'
            ]);
        }
    }
}
