<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdhikariController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ComplaintCatagoryController;
use App\Http\Controllers\ComplaintCategoryController;
use App\Http\Controllers\ComplaintDetailsController;
use App\Http\Controllers\ComplaintSubCategoryController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DevelopmentWorkController;
use App\Http\Controllers\DevelopmentWorkDetailsController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\GaonController;
use App\Http\Controllers\InfluentialPersonsController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationTypeController;
use App\Http\Controllers\KhatavaniDetailsController;
use App\Http\Controllers\OutofTownVoterController;
use App\Http\Controllers\PartyWorkersController;
use App\Http\Controllers\ProposedWorkController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SarpanchController;
use App\Http\Controllers\SocialElementController;
use App\Http\Controllers\SocialElementMasterController;
use App\Http\Controllers\TalukaPanchayatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VotersbyCasteController;
use App\Http\Controllers\VotesReceivedByBjpController;
use App\Http\Controllers\WardAreaController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\ZillaParishadController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterInwardController;
use App\Http\Controllers\RegisterOutwardController;
use App\Http\Controllers\LetterTypeController;
use App\Http\Controllers\VillageDevelopmentWorkController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\VehicalController;
use App\Http\Controllers\FuelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clear-cache', function () {
   Artisan::call('cache:clear');
   Artisan::call('route:clear');

   return "Cache cleared successfully";
});



// ======================== Register =========================================
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
     Route::post('/logout', [AuthController::class, 'logout']);
});

//Route::get('viewAllRegisters', [AuthController::class, 'viewAllRegisters']);
Route::get('viewAllRegistrations', [AuthController::class, 'viewAllRegisters']);
Route::get('ViewRegisterById/{id}', [AuthController::class, 'ViewRegisterById']);
Route::post('updateregister/{id}', [AuthController::class, 'edit']);

// ============================================Assembly============================================================
Route::post('addAssembly', [AssemblyController::class, 'store']);
Route::get('viewAssembly', [AssemblyController::class, 'index']);
Route::get('assembly/show/{assemblyId}', [AssemblyController::class, 'show']);
Route::put('assembly/update/{assemblyId}', [AssemblyController::class, 'update']);
Route::delete('assembly/delete/{assemblyId}', [AssemblyController::class, 'destroy']);

// ============================================Ward============================================================
Route::post('addWard', [WardController::class, 'store']);
Route::get('viewWard', [WardController::class, 'index']);
Route::get('ward/show/{wardId}', [WardController::class, 'show']);
Route::get('getWardByAssemblyId/{assemblyId}', [WardController::class, 'getWardByAssemblyId']);
Route::put('ward/update/{wardId}', [WardController::class, 'update']);
Route::delete('ward/delete/{wardId}', [WardController::class, 'destroy']);

// ============================================WardArea============================================================
Route::post('addWardArea', [WardAreaController::class, 'store']);
Route::get('viewWardArea', [WardAreaController::class, 'index']);
Route::get('wardArea/show/{wardAreaId}', [WardAreaController::class, 'show']);
Route::get('getwardAreaByWardId/{wardId}', [WardAreaController::class, 'getwardAreaByWardId']);
Route::put('wardArea/update/{wardAreaId}', [WardAreaController::class, 'update']);
Route::delete('wardArea/delete/{wardAreaId}', [WardAreaController::class, 'destroy']);

// ============================================Gaon=============================================================
Route::post('addGaon', [GaonController::class, 'store']);
Route::get('viewGaon', [GaonController::class, 'index']);
Route::get('gaon/show/{gaonId}', [GaonController::class, 'show']);
Route::get('getGaonByTalukaPanchayatId/{talukaPanchayatId}', [GaonController::class, 'getGaonByTalukaPanchayatId']);
Route::put('gaon/update/{gaonId}', [GaonController::class, 'update']);
Route::delete('gaon/delete/{gaonId}', [GaonController::class, 'destroy']);
Route::get('getGaonByZillaParishad/{zillaParishad}', [GaonController::class, 'getGaonByZillaParishad']);

// ============================================ComplaintCategory=============================================================
Route::post('addComplaintCategory', [ComplaintCategoryController::class, 'store']);
Route::get('viewComplaintCategory', [ComplaintCategoryController::class, 'index']);
Route::get('complaintCategory/show/{complaintCategoryId}', [ComplaintCategoryController::class, 'show']);
Route::put('complaintCategory/update/{complaintCategoryId}', [ComplaintCategoryController::class, 'update']);
Route::delete('complaintCategory/delete/{complaintCategoryId}', [ComplaintCategoryController::class, 'destroy']);

// ============================================ComplaintSubCategory=============================================================
Route::post('addComplaintSubCategory', [ComplaintSubCategoryController::class, 'store']);
Route::get('viewComplaintSubCategory', [ComplaintSubCategoryController::class, 'index']);
Route::get('complaintSubCategory/show/{complaintSubCategoryId}', [ComplaintSubCategoryController::class, 'show']);
Route::get('getComplaintSubCategoryByComplaintCategoryId/{complaintCategoryId}', [ComplaintSubCategoryController::class, 'getComplaintSubCategoryByComplaintCategoryId']);
Route::put('complaintSubCategory/update/{complaintSubCategoryId}', [ComplaintSubCategoryController::class, 'update']);
Route::delete('complaintSubCategory/delete/{complaintSubCategoryId}', [ComplaintSubCategoryController::class, 'destroy']);

// ============================================Adhikari=============================================================
Route::post('addAdhikari', [AdhikariController::class, 'store']);
Route::get('viewAdhikari/{pageNo}/{pageSize}/{contact?}/{fname?}', [AdhikariController::class, 'index']); 
Route::get('viewAdhikariCount', [AdhikariController::class, 'count']);
Route::get('adhikari/show/{adhikariId}', [AdhikariController::class, 'show']);
Route::post('adhikari/update/{adhikariId}', [AdhikariController::class, 'update']);
Route::delete('adhikari/delete/{adhikariId}', [AdhikariController::class, 'destroy']);

// ============================================ComplaintDetails=============================================================
Route::post('addComplaintDetails', [ComplaintDetailsController::class, 'store']);
Route::get('viewComplaintDetails', [ComplaintDetailsController::class, 'index']);
Route::get('complaintDetails/show/{complaintDetailsId}', [ComplaintDetailsController::class, 'show']);
Route::get('viewComplaintsByComplainerId/{complainerId}', [ComplaintDetailsController::class, 'viewComplaintsByComplainerId']);
Route::put('complaintDetails/updateStatus/{complaintDetailsId}',[ComplaintDetailsController::class,'updateStatus']);
Route::post('complaintDetails/update/{complaintDetailsId}', [ComplaintDetailsController::class, 'update']);
Route::delete('complaintDetails/delete/{complaintDetailsId}', [ComplaintDetailsController::class, 'destroy']);
Route::get('searchcomplaintDetails/{complaintCategoryId?}/{complaintSubCategoryId?}/{assemblyId?}/{cityType?}/{wardId?}/{wardAreaId?}/{zillaParishadId?}/{talukaPanchayatId?}/{gaonId?}/{status?}/{FromDate?}/{ToDate?}',[ComplaintDetailsController::class,'getComplaintDetailsByFilter']);
Route::get('ViewComplaintByPagination/{pageNo}/{pageSize}/{token?}/{status?}/{person?}', [ComplaintDetailsController::class, 'ViewComplaintByPagination']);
Route::get('searchByToken/{token}', [ComplaintDetailsController::class, 'searchByToken']);
Route::get('searchComplaintsByTokenOrStatus/{token?}/{status?}', [ComplaintDetailsController::class, 'searchComplaintsByTokenOrStatus']);

// ============================================DevelopmentWork=============================================================
Route::post('addDevelopmentWork', [DevelopmentWorkController::class, 'store']);
Route::get('viewDevelopmentWork', [DevelopmentWorkController::class, 'index']);
Route::get('developmentWork/show/{developmentWorkId}', [DevelopmentWorkController::class, 'show']);
Route::put('developmentWork/update/{developmentWorkId}', [DevelopmentWorkController::class, 'update']);
Route::delete('developmentWork/delete/{developmentWorkId}', [DevelopmentWorkController::class, 'destroy']);

// ============================================DevelopmentWorkDetails=============================================================
Route::post('addDevelopmentWorkDetails', [DevelopmentWorkDetailsController::class, 'store']);
Route::get('viewDevelopmentWorkDetails/{gaonId?}/{wardId?}', [DevelopmentWorkDetailsController::class, 'index']);
Route::get('developmentWorkDetails/show/{developmentWorkDetailsId}', [DevelopmentWorkDetailsController::class, 'show']);
Route::post('developmentWorkDetails/update/{developmentWorkDetailsId}', [DevelopmentWorkDetailsController::class, 'update']);
Route::put('developmentWorkDetails/updateStatus/{developmentWorkDetailsId}', [DevelopmentWorkDetailsController::class, 'updateStatus']);
Route::delete('developmentWorkDetails/delete/{developmentWorkDetailsId}', [DevelopmentWorkDetailsController::class, 'destroy']);
Route::get('viewWorkDetailByPagination/{pageNo}/{pageSize}/{status?}', [DevelopmentWorkDetailsController::class, 'viewWorkDetailByPagination']);
Route::get('searchDevelopmentWorkDetailsByTokenOrStatus/{status?}', [DevelopmentWorkDetailsController::class, 'searchDevelopmentWorkDetailsByTokenOrStatus']);
Route::get('viewWorkDetailByFilter/{workStatus?}/{developmentWorkId?}/{assemblyId?}/{cityType?}/{wardId?}/{wardAreaId?}/{gaonId?}/{talukaPanchayatId?}/{zillaParishadId?}/{fromDate?}/{toDate?}/{tentiveFromDate?}/{tentiveToDate?}', [DevelopmentWorkDetailsController::class, 'viewWorkDetailByFilter']);

// ============================================LetterType=============================================================
Route::post('addLetterType', [LetterTypeController::class, 'store']);
Route::get('viewLetterType', [LetterTypeController::class, 'index']);
Route::get('letterType/show/{letterTypeId}', [LetterTypeController::class, 'show']);
Route::put('letterType/update/{letterTypeId}', [LetterTypeController::class, 'update']);
Route::delete('letterType/delete/{letterTypeId}', [LetterTypeController::class, 'destroy']);

// ============================================Vehical=============================================================
Route::post('addVehical', [VehicalController::class, 'store']);
Route::get('viewVehical', [VehicalController::class, 'index']);
Route::get('vehical/show/{vehicalId}', [VehicalController::class, 'show']);
Route::put('vehical/update/{vehicalId}', [VehicalController::class, 'update']);
Route::delete('vehical/delete/{vehicalId}', [VehicalController::class, 'destroy']);

// ============================================Fuel=============================================================
Route::post('addFuel', [FuelController::class, 'store']);
Route::get('viewFuel/{pageNo}/{pageSize}/{vehicleId?}/{FromDate?}/{ToDate?}', [FuelController::class, 'index']);
Route::get('fuel/show/{fuelId}', [FuelController::class, 'show']);
Route::put('fuel/update/{fuelId}', [FuelController::class, 'update']);
Route::delete('fuel/delete/{fuelId}', [FuelController::class, 'destroy']);
Route::get('fuel/showVehicleIdWise/{vehicalId}', [FuelController::class, 'showVehicleIdWise']);


// ============================================Register=============================================================
Route::post('addRegister', [RegisterController::class, 'store']);
Route::get('viewRegister', [RegisterController::class, 'index']);
Route::get('register/show/{registerId}', [RegisterController::class, 'show']);
//Route::get('viewRegisterByPagination/{pageNo}', [RegisterController::class, 'viewRegisterByPagination']);
Route::get('showRegisterByRegisterType/{pageNo}/{pageSize}/{registerType?}/{token?}/{status?}/{person?}', [RegisterController::class, 'showRegisterByRegisterType']);
Route::get('showRegisterByFilter/{letterTypeId?}/{registerType?}/{priority?}/{departmentId?}/{assemblyId?}/{cityType?}/{wardId?}/{wardAreaId?}/{gaonId?}/{talukaPanchayatId?}/{zillaParishadId?}/{fromDate?}/{toDate?}', [RegisterController::class, 'showRegisterByFilter']);
Route::post('register/update/{registerId}', [RegisterController::class, 'update']);
Route::put('register/updateStatus/{registerId}', [RegisterController::class, 'updateStatus']);
Route::delete('register/delete/{registerId}', [RegisterController::class, 'destroy']);
// Route::get('searchRegisterByTokenOrStatus/{token?}/{status?}/{perPage}', [RegisterController::class, 'searchRegisterByTokenOrStatus']);
//Route::get('searchRegisterByTokenOrStatus/{token?}/{status?}/{pageNo?}/{registerType?}', [RegisterController::class, 'searchRegisterByTokenOrStatus']);
Route::get('registerCount', [RegisterController::class, 'count']);
Route::get('viewRegisterStatusCount', [RegisterController::class, 'viewRegisterStatusCount']);

// ============================================RegisterInward=============================================================
Route::post('addRegisterInward', [RegisterInwardController::class, 'store']);
// Route::get('viewRegisterInward', [RegisterInwardController::class, 'index']);
Route::get('registerInward/show/{registerInwardId}', [RegisterInwardController::class, 'show']);
Route::get('viewRegisterInwardByPagination/{pageNo}', [RegisterInwardController::class, 'viewRegisterInwardByPagination']);
Route::post('registerInward/update/{registerInwardId}', [RegisterInwardController::class, 'update']);
Route::delete('registerInward/delete/{registerInwardId}', [RegisterInwardController::class, 'destroy']);

// ============================================RegisterOutward=============================================================
Route::post('addRegisterOutward', [RegisterOutwardController::class, 'store']);
// Route::get('viewRegisterOutward', [RegisterOutwardController::class, 'index']);
Route::get('registerOutward/show/{registerOutwardId}', [RegisterOutwardController::class, 'show']);
Route::get('viewRegisterOutwardByPagination/{pageNo}', [RegisterOutwardController::class, 'viewRegisterOutwardByPagination']);
Route::put('registerOutward/update/{registerOutwardId}', [RegisterOutwardController::class, 'update']);
Route::delete('registerOutward/delete/{registerOutwardId}', [RegisterOutwardController::class, 'destroy']);

// ======================  Taluka Panchayat =================================================
Route::post('talukapanchayat/add', [TalukaPanchayatController::class, 'store']);
Route::get('talukapanchayat/viewall', [TalukaPanchayatController::class, 'viewAll']);
Route::get('talukapanchayat/vewById/{id}', [TalukaPanchayatController::class, 'viewById']);
Route::put('talukapanchayat/update/{id}', [TalukaPanchayatController::class, 'edit']);
Route::delete('talukapanchayat/delete/{id}', [TalukaPanchayatController::class, 'destroy']);
Route::get('talukapanchayat/talukaPanchayatByZillaParishadId/{zillaParishadId}', [TalukaPanchayatController::class, 'talukaPanchayatByZillaParishadId']);

// ======================= Zilla Parishad ============================================
Route::post('zillaparishad/add', [ZillaParishadController::class, 'store']);
Route::get('zillaparishad/viewall', [ZillaParishadController::class, 'viewAll']);
Route::get('zillaparishad/vewById/{id}', [ZillaParishadController::class, 'viewById']);
Route::put('zillaparishad/update/{id}', [ZillaParishadController::class, 'edit']);
Route::delete('zillaparishad/delete/{id}', [ZillaParishadController::class, 'destroy']);
Route::get('zillaparishad/zillaParishadByassemblyId/{assemblyId}', [ZillaParishadController::class, 'zillaParishadByassemblyId']);

// ==================================== Catagory ===============================================
Route::post('catagory/add', [ComplaintCatagoryController::class, 'store']);
Route::get('catagory/viewall', [ComplaintCatagoryController::class, 'viewAll']);
Route::get('catagory/vewById/{id}', [ComplaintCatagoryController::class, 'viewById']);
Route::put('catagory/update/{id}', [ComplaintCatagoryController::class, 'edit']);
Route::delete('catagory/delete/{id}', [ComplaintCatagoryController::class, 'destroy']);

// ==================================== complaint type ===============================================
Route::post('type/complaint/add', [ComplaintTypeController::class, 'store']);
Route::get('type/complaint/viewall', [ComplaintTypeController::class, 'viewAll']);
Route::get('type/complaint/vewById/{id}', [ComplaintTypeController::class, 'viewById']);
Route::put('type/complaint/update/{id}', [ComplaintTypeController::class, 'edit']);
Route::delete('type/complaint/delete/{id}', [ComplaintTypeController::class, 'destroy']);
Route::get('type/complaint/complaintByCataory/{catagoryId}', [ComplaintTypeController::class, 'complaintByCataory']);

// ============================ User ========================================
Route::post('addUser', [UserController::class, 'store']);
// Route::get('viewByContactNumberAndAadharNumber/{contact?}/{aadhar?}', [UserController::class, 'viewByContactNumberAndAadharNumber']);
Route::get('viewCitizenByContactNumberAndAadharNumberAndName/{pageNo}/{pageSize}/{contact?}/{aadhar?}/{fname?}', [UserController::class, 'viewCitizenByContactNumberAndAadharNumberAndName']);
Route::get('getCitizenByRole/{role}', [UserController::class, 'getCitizenByRole']);
Route::get('getCitienByGaonId/{gaonId}', [UserController::class, 'getCitienByGaonId']);
Route::get('getCitizen', [UserController::class, 'viewAll']);
Route::get('getCitienByid/{id}', [UserController::class, 'viewCitizenById']);
Route::post('updateCitizen/{id}', [UserController::class, 'edit']);
Route::get('ViewAllCitizenByPagination/{pageNo}/{pageSize}/{contact?}/{aadhar?}/{fname?}/{role?}', [UserController::class, 'ViewAllByPagination']);
Route::get('viewPaginate', [UserController::class, 'viewPaginate']);
Route::get('viewKaryakartaCount', [UserController::class, 'viewKaryakartaCount']);
Route::get('todaysBirthday/{todayDate}', [UserController::class, 'todaysBirthday']);

// ============================ Invitation Type ========================================
Route::post('addinvitationType', [InvitationTypeController::class, 'store']);
Route::get('viewallInvitationType', [InvitationTypeController::class, 'viewAll']);
Route::get('vewInvitationTypeById/{id}', [InvitationTypeController::class, 'viewById']);
Route::put('updateInvitationType/{id}', [InvitationTypeController::class, 'edit']);
Route::delete('deleteInvitationType/{id}', [InvitationTypeController::class, 'destroy']);

// ============================ Route ========================================
Route::post('addroute', [RouteController::class, 'store']);
Route::get('viewAllRoute', [RouteController::class, 'viewAll']);
Route::get('viewRouteById/{id}', [RouteController::class, 'viewById']);
Route::put('updateRoute/{id}', [RouteController::class, 'edit']);
Route::delete('deleteRoute/{id}', [RouteController::class, 'destroy']);

// ==================================== Event Type ===============================================
Route::post('eventType/add', [EventTypeController::class, 'store']);
Route::get('eventType/viewall', [EventTypeController::class, 'viewAll']);
Route::get('eventType/vewById/{id}', [EventTypeController::class, 'viewById']);
Route::put('eventType/update/{id}', [EventTypeController::class, 'edit']);
Route::delete('eventType/delete/{id}', [EventTypeController::class, 'destroy']);

// ==================================== Department ===============================================
Route::post('department/add', [DepartmentController::class, 'store']);
Route::get('department/viewall', [DepartmentController::class, 'viewAll']);
Route::get('department/vewById/{id}', [DepartmentController::class, 'viewById']);
Route::put('department/update/{id}', [DepartmentController::class, 'edit']);
Route::delete('department/delete/{id}', [DepartmentController::class, 'destroy']);
Route::get('department/departmentByComplaintTypeId/{complaintTypeId}', [DepartmentController::class, 'departmentByComplaintTypeId']);

// ============================ Invitation ========================================
Route::post('addInvitation', [InvitationController::class, 'store']);
Route::get('viewAllInvitation', [InvitationController::class, 'viewAll']);
Route::get('viewInvitationById/{id}', [InvitationController::class, 'viewInvitationById']);
Route::get('viewAllInvitationBydate/{FromDate}/{ToDate}', [InvitationController::class, 'viewAllInvitationBydate']);
Route::put('updateInvitation/{id}', [InvitationController::class, 'edit']);
// Route::delete('deleteRoute/{id}', [InvitationController::class, 'destroy']);
Route::get('searchInvitation/{priority?}/{status?}/{eventTypeId?}/{routeid?}/{assemblyid?}/{cityType?}/{FromDate?}/{ToDate?}', [InvitationController::class, 'getInvitationsByFilter']);
Route::get('getInvitationsByFilterNew/{priority?}/{status?}/{eventTypeId?}/{routeid?}/{assemblyid?}/{cityType?}/{wardId?}/{wardAreaId?}/{gaonId?}/{talukaPanchayatId?}/{zillaParishadId?}/{FromDate?}/{ToDate?}', [InvitationController::class, 'getInvitationsByFilterNew']);
Route::get('viewInvitationByPagination/{pageNo}/{pageSize}/{token?}/{status?}/{person?}', [InvitationController::class, 'viewInvitationByPagination']);
Route::get('searchInvitationByTokenOrStatus/{token?}/{status?}', [InvitationController::class, 'searchInvitationByTokenOrStatus']);
Route::delete('deleteInvitation/{invitationId}', [InvitationController::class, 'deleteInvitation']);

// ============================ Khatavni ========================================
Route::post('addKhatavni', [KhatavaniDetailsController::class, 'store']);
Route::get('getKhatavniByGaonId/{gaonId}/{type}', [KhatavaniDetailsController::class, 'getKhatavniByGaonId']);
Route::put('updateKhatavni/{khataniId}', [KhatavaniDetailsController::class, 'edit']);
Route::put('khatavniSoftDelete/{khataniId}', [KhatavaniDetailsController::class, 'destroy']);

// ============================ BJP voters ========================================
Route::post('addVotesbybjp', [VotesReceivedByBjpController::class, 'store']);
Route::get('getBJPVoterByGaonId/{gaonId}/{type}', [VotesReceivedByBjpController::class, 'getBJPVoterByGaonId']);
Route::put('updateBJPVoters/{id}', [VotesReceivedByBjpController::class, 'edit']);
Route::put('bjpVotesSoftDelete/{id}', [VotesReceivedByBjpController::class, 'destroy']);

// ============================ Sarpanch ========================================
Route::post('addsarpanch', [SarpanchController::class, 'store']);
Route::get('getSarpanchByGaonId/{gaonId}/{type}', [SarpanchController::class, 'getSarpanchByGaonId']);
Route::put('updateSarpanch/{id}', [SarpanchController::class, 'edit']);
Route::put('sarpanchSoftDelete/{id}', [SarpanchController::class, 'destroy']);

// ============================ Party Worker ========================================
Route::post('addpartyWorker', [PartyWorkersController::class, 'store']);
Route::get('getPartyWorkerByGaonId/{gaonId}/{type}', [PartyWorkersController::class, 'getPartyWorkerByGaonId']);
Route::put('updatePartyWorker/{id}', [PartyWorkersController::class, 'edit']);
Route::put('partyWorkerSoftDelete/{id}', [PartyWorkersController::class, 'destroy']);

// ============================ Influential Person ========================================
Route::post('addInfluencerPerson', [InfluentialPersonsController::class, 'store']);
Route::get('getInfluentialPersonByGaonId/{gaonId}/{type}', [InfluentialPersonsController::class, 'getInfluentialPersonByGaonId']);
Route::put('updateinfluentialPerson/{id}', [InluentialPersonsController::class, 'edit']);
Route::put('influentialPersonSoftDelete/{id}', [InfluentialPersonsController::class, 'destroy']);

// ============================ Proposed Worker ========================================
Route::post('addProposedWork', [ProposedWorkController::class, 'store']);
Route::get('getProposedWorkByGaonId/{gaonId}/{type}', [ProposedWorkController::class, 'getProposedWorkByGaonId']);
Route::put('updateProposedWork/{id}', [ProposedWorkController::class, 'edit']);
Route::put('proposedWorkSoftDelete/{id}', [ProposedWorkController::class, 'destroy']);

// ============================ out of town ========================================
Route::post('addOutOfTownVoter', [OutofTownVoterController::class, 'store']);
Route::get('GetOutOfTownVotersBygaonId/{gaonId}/{type}', [OutofTownVoterController::class, 'GetOutOfTownVotersBygaonId']);
Route::put('updateOutOfTownVoter/{id}', [OutofTownVoterController::class, 'edit']);
Route::put('outOfTownVoterSoftDelete/{id}', [OutofTownVoterController::class, 'destroy']);

// ============================ Social Element Master ========================================
Route::post('addSocialElementMaster', [SocialElementMasterController::class, 'store']);
Route::get('getAllSocialElements', [SocialElementMasterController::class, 'getAllSocialElements']);
Route::put('updateSocialElementMaster/{id}', [SocialElementMasterController::class, 'edit']);

// ============================ Social Element ========================================
Route::post('addSocialElement', [SocialElementController::class, 'store']);
Route::get('getsocialElementbyGaon/{gaonId}/{type}', [SocialElementController::class, 'getsocialElementbyGaon']);
Route::put('updateSocialElement/{id}', [SocialElementController::class, 'edit']);
Route::put('socialElementSoftDelete/{id}', [SocialElementController::class, 'destroy']);

// ============================ Cast Voters ========================================
Route::post('addvotersByCast', [VotersbyCasteController::class, 'store']);
Route::get('getCastVotersByGaonId/{gaonId}/{type}', [VotersbyCasteController::class, 'getCastVotersByGaonId']);
Route::put('updateCastVoters/{id}', [VotersbyCasteController::class, 'edit']);
Route::put('castVoteSoftDelete/{id}', [VotersbyCasteController::class, 'destroy']);

// ==================================== DashBoard ===============================================
Route::get('viewComplaintsCounts', [DashBoardController::class, 'viewComplaintsCounts']);
Route::get('viewInvitationsCounts', [DashBoardController::class, 'viewInvitationsCounts']);
Route::get('viewInvitationsCountsByDates/{dateFrom}/{dateTo}', [DashBoardController::class, 'viewInvitationsCountsByDate']);
Route::get('viewDevelopmentWorkDetailsCounts', [DashBoardController::class, 'viewDevelopmentWorkDetailsCounts']);

// ==================================== Village Development Work ===============================================
Route::post('addVillageDevelopmentWork', [VillageDevelopmentWorkController::class, 'store']);
Route::get('viewVillageDevelopmentWorkByGaonId/{gaonId}', [VillageDevelopmentWorkController::class, 'viewByGaonId']);
Route::put('villageDevelopmentWorkSoftDelete/{id}', [VillageDevelopmentWorkController::class, 'destroy']);

// ============================================Permission=============================================================
Route::post('addPermission', [PermissionController::class, 'store']);
Route::get('viewPermission', [PermissionController::class, 'index']);
Route::get('permission/show/{permissionId}', [PermissionController::class, 'show']);
Route::put('permission/update/{permissionId}', [PermissionController::class, 'update']);
Route::delete('permission/delete/{permissionId}', [PermissionController::class, 'destroy']);

// ============================================UserPermission=============================================================
Route::post('addUserPermission/{userId}', [UserPermissionController::class, 'store']);
Route::get('viewUserPermission', [UserPermissionController::class, 'index']);
Route::get('userPermission/show/{userPermissionId}', [UserPermissionController::class, 'show']);
Route::put('userPermission/update/{permissionId}', [UserPermissionController::class, 'update']);
Route::delete('userPermission/delete/{userPermissionId}', [UserPermissionController::class, 'destroy']);
Route::post('updatePermissionByUserId/{userId}', [UserPermissionController::class, 'updatePermissionByUserId']);
