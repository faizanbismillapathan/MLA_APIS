<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Adhikari;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\IsEmpty;
use Tymon\JWTAuth\Facades\JWTAuth;

use function PHPUnit\Framework\isEmpty;

class AdhikariController extends Controller
{
    //Add Adhikari
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'middleName' => '',
            'lastName' => 'required',
            'gender' => '',
            'mobileNo' => 'required',
            'alternateNo' => '',
            'departmentId' => 'required',
            'designation' => 'required',
            'education' => '',
            'dateOfBirth' => '',
            'address' => '',
            'photo' => '',
            'userId' => 'required',
        ]);

        // Add Adhikari Data
        $Adhikari=new Adhikari();
        $Adhikari->firstName=$request->firstName;
        $Adhikari->middleName=$request->middleName;
        $Adhikari->lastName=$request->lastName;
        $Adhikari->gender=$request->gender;
        $Adhikari->mobileNo=$request->mobileNo;
        $Adhikari->alternateNo=$request->alternateNo;
        $Adhikari->departmentId=$request->departmentId;
        $Adhikari->designation=$request->designation;
        $Adhikari->education=$request->education;
        $Adhikari->dateOfBirth=$request->dateOfBirth;
        $Adhikari->address=$request->address;
        if($request->photo){
            $AdhikariPhoto = $request->photo;
            $new_name=$AdhikariPhoto.'_'.date('YmdHis').'.'.$AdhikariPhoto->getClientOriginalExtension();
            $AdhikariPhoto->move(public_path('/AdhikariPhoto'),$new_name);
            $Adhikari->photo=$new_name;
        }else{
            $Adhikari->photo="NULL";
        }
        $Adhikari->created_by=$request->userId;
        $Adhikari->save();

        if ($Adhikari) {
            return response()->json([
                'code' => 200,
                'data' => $Adhikari,
                'message' => 'Adhikari Added Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Adhikari Not Added',
            ]);
        }
    }

    // View All Adhikari
   /* public function index()
    {
        $Adhikaris = Adhikari::select('adhikari.id as adhikariId','adhikari.firstName','adhikari.middleName','adhikari.lastName','adhikari.gender','adhikari.mobileNo','adhikari.alternateNo','adhikari.departmentId','departments.departmentName','adhikari.designation','adhikari.education','adhikari.dateOfBirth','adhikari.address','adhikari.photo','adhikari.created_by','adhikari.updated_by')
        ->leftjoin('departments','adhikari.departmentId','departments.id')
        ->orderBy('adhikari.id', 'desc')
        ->get();
        foreach($Adhikaris as $Adhikari){
            $res=[
                'adhikariId'=>$Adhikari->adhikariId,
                'firstName'=>$Adhikari->firstName,
                'middleName'=>$Adhikari->middleName,
                'lastName'=>$Adhikari->lastName,
                'gender'=>$Adhikari->gender,
                'mobileNo'=>$Adhikari->mobileNo,
                'alternateNo'=>$Adhikari->alternateNo,
                'departmentId'=>$Adhikari->departmentId,
                'departmentName'=>$Adhikari->departmentName,
                'dateOfBirth'=>$Adhikari->dateOfBirth,
                'designation'=>$Adhikari->designation,
                'education'=>$Adhikari->education,
                'address'=>$Adhikari->address,
                'photo'=>'https://mlaapi.orisunlifescience.coms/public/AdhikariPhoto/'.$Adhikari->photo,
                'created_by'=>$Adhikari->created_by,
                'updated_by'=>$Adhikari->updated_by,
            ];
            $result[]=$res;
        }
        if (count($Adhikaris)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $result,
                'message' => 'Adhikari Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Adhikari Not Found',
            ]);
        }
    }*/

    // Vipul
      // View All Adhikari
//     public function index($pageNo, $pageSize, $contact = null, $fname = null)
// {
//     $Adhikaris = Adhikari::select(
//         'adhikari.id as adhikariId',
//         'adhikari.firstName',
//         'adhikari.middleName',
//         'adhikari.lastName',
//         'adhikari.gender',
//         'adhikari.mobileNo',
//         'adhikari.alternateNo',
//         'adhikari.departmentId',
//         'departments.departmentName',
//         'adhikari.designation',
//         'adhikari.education',
//         'adhikari.dateOfBirth',
//         'adhikari.address',
//         'adhikari.photo',
//         'adhikari.created_by',
//         'adhikari.updated_by'
//     )
//         ->leftJoin('departments', 'adhikari.departmentId', 'departments.id');

//     if ($contact) {
//         $Adhikaris->where('adhikari.mobileNo', $contact);
//     }

//     if ($fname) {
//         $Adhikaris->where('adhikari.firstName', $fname);
//     }

//     $Adhikaris->orderBy('adhikari.id', 'desc')
//         ->selectRaw('ROW_NUMBER() OVER (ORDER BY adhikari.id desc) AS RowNum');

//     $count = $Adhikaris->count();
//     $totalPage = ceil($count / $pageSize);

//     $subquery = DB::table(DB::raw("({$Adhikaris->toSql()}) as sub"))
//         ->mergeBindings($Adhikaris->getQuery())
//         ->whereBetween('RowNum', [($pageNo - 1) * $pageSize + 1, $pageNo * $pageSize]);

//     $Adhikaris = $subquery->get();

//     if (count($Adhikaris) !== 0) {
//         return response()->json([
//             'code' => 200,
//             'data' => $Adhikaris,
//             'currentPage' => $pageNo,
//             'count' => $count,
//             'totalPage' => $totalPage,
//             'message' => 'Adhikari Fetched Successfully',
//         ]);
//     } else {
//         return response()->json([
//             'code' => 404,
//             'data' => [],
//             'message' => 'Data Not Found',
//         ]);
//     }
// }

public function index($pageNo, $pageSize, $contact = null, $fname = null)
{
    $Adhikaris = Adhikari::select(
        'adhikari.id as adhikariId',
        'adhikari.firstName',
        'adhikari.middleName',
        'adhikari.lastName',
        'adhikari.gender',
        'adhikari.mobileNo',
        'adhikari.alternateNo',
        'adhikari.departmentId',
        'departments.departmentName',
        'adhikari.designation',
        'adhikari.education',
        'adhikari.dateOfBirth',
        'adhikari.address',
        'adhikari.photo',
        'adhikari.created_by',
        'adhikari.updated_by'
    )
    ->leftJoin('departments', 'adhikari.departmentId', 'departments.id')
    ->when($contact, function ($query, $contact) {
        return $query->where('adhikari.mobileNo', $contact);
    })
    ->when($fname, function ($query, $fname) {
        return $query->where('adhikari.firstName', $fname);
    })
    ->orderBy('adhikari.id', 'desc');

    $count = $Adhikaris->count();
    $totalPage = ceil($count / $pageSize);

    $Adhikaris = $Adhikaris
        ->offset(($pageNo - 1) * $pageSize)
        ->limit($pageSize)
        ->get();

    if ($Adhikaris->isNotEmpty()) {
        return response()->json([
            'code' => 200,
            'data' => $Adhikaris,
            'currentPage' => $pageNo,
            'count' => $count,
            'totalPage' => $totalPage,
            'message' => 'Adhikari Fetched Successfully',
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
    public function show($adhikariId)
    {
         $path = 'https://mlaapi.orisunlifescience.com/public/Photo/';
        $Adhikaris = Adhikari::select('adhikari.id as adhikariId','adhikari.firstName','adhikari.middleName','adhikari.lastName','adhikari.gender','adhikari.mobileNo','adhikari.alternateNo','adhikari.departmentId','departments.departmentName','adhikari.designation','adhikari.education','adhikari.dateOfBirth','adhikari.address','adhikari.photo','adhikari.created_by','adhikari.updated_by')->leftjoin('departments','adhikari.departmentId','departments.id')
        ->where('adhikari.id', $adhikariId)->get();

        foreach($Adhikaris as $Adhikari){
            $res=[
                'adhikariId'=>$Adhikari->adhikariId,
                'firstName'=>$Adhikari->firstName,
                'middleName'=>$Adhikari->middleName,
                'lastName'=>$Adhikari->lastName,
                'gender'=>$Adhikari->gender,
                'mobileNo'=>$Adhikari->mobileNo,
                'alternateNo'=>$Adhikari->alternateNo,
                'departmentId'=>$Adhikari->departmentId,
                'departmentName'=>$Adhikari->departmentName,
                'dateOfBirth'=>$Adhikari->dateOfBirth,
                'designation'=>$Adhikari->designation,
                'education'=>$Adhikari->education,
                'address'=>$Adhikari->address,
                'photo'=>($Adhikari->photo==Null) ? 'user-vector.jpg' : $Adhikari->photo,
                'photopath'=> ($Adhikari->photo==Null) ? ( 'https://mlaapi.sapnakabraart.com/public/Photo/user-vector.jpg') : ( 'https://mlaapi.sapnakabraart.com/public/Photo/' . $Adhikari->photo),
                'created_by'=>$Adhikari->created_by,
                'updated_by'=>$Adhikari->updated_by,
            ];
            $result[]=$res;
        }
        if (count($Adhikaris)!=0) {
            return response()->json([
                'code' => 200,
                'data' => $result[0],
                'message' => 'Adhikari Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Adhikari Not Found',
            ]);
        }
    }

    //Update Adhikari
    public function update(Request $request, $adhikariId)
    {
        $request->validate([
            'firstName' => '',
            'middleName' => '',
            'lastName' => '',
            'gender' => '',
            'mobileNo' => '',
            'alternateNo' => '',
            'departmentId' => '',
            'designation' => '',
            'education' => '',
            'dateOfBirth' => '',
            'address' => '',
            'photo' => '',
            'userId' => 'required',
        ]);

        $Adhikari = Adhikari::find($adhikariId);
        if ($Adhikari) {
            $Adhikari->firstName = $request->firstName;
            $Adhikari->middleName=$request->middleName;
            $Adhikari->lastName=$request->lastName;
            $Adhikari->gender=$request->gender;
            $Adhikari->mobileNo=$request->mobileNo;
            $Adhikari->alternateNo=$request->alternateNo;
            $Adhikari->departmentId=$request->departmentId;
            $Adhikari->designation=$request->designation;
            $Adhikari->education=$request->education;
            $Adhikari->dateOfBirth=$request->dateOfBirth;
            $Adhikari->address=$request->address;
            if($request->hasFile('photo')){
                $AdhikariPhoto = $request->photo;
                $new_name=$AdhikariPhoto.'_'.date('YmdHis').'.'.$AdhikariPhoto->getClientOriginalExtension();
                $AdhikariPhoto->move(public_path('/AdhikariPhoto'),$new_name);
                $Adhikari->photo=$new_name;
            }else{
                $Adhikari->photo="NULL";
            }
        $Adhikari->updated_by=$request->userId;
        $Adhikari->update();

            return response()->json([
                'code' => 200,
                'data' => $Adhikari,
                'message' => 'Adhikari Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Adhikari Not Found',
            ]);
        }
    }

    //Delete Adhikari
    public function destroy($adhikariId)
    {
        $Adhikari = Adhikari::find($adhikariId);

        if ($Adhikari) {
            $Adhikari->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Adhikari deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Adhikari Not Found',
            ]);
        }
    }
    public function count(){
        $Adhikari=Adhikari::count();
        if ($Adhikari) {
            return response()->json([
                'code' => 200,
                'data' => $Adhikari,
                'message' => 'Adhikari Count Fetched Sucecssfully',
            ]);
        } else {
            return response()->json([
                'code' => 404,
                'data' => [],
                'message' => 'Adhikari Not Found',
            ]);
        }
    }
}
