<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComplaintDetails;
use Illuminate\Support\Facades\DB;
use App\Models\Images;
use App\Models\Invitation;



class DashBoardController extends Controller
{
    // public function dashBoardAllCount()
    // {
    //     $dashBoard = ComplaintDetails::all();
    //     if ($dashBoard) {
    //         return response()->json([
    //             'code' => 200,
    //             'data' => $dashBoard,
    //             'message' => 'dashBoard Fetched',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'code' => 404,
    //             'data' => [],
    //             'message' => 'dashBoard Not Found',
    //         ]);
    //     }
    // }

    public function viewComplaintsCounts()
    {
        $counts = DB::table('complaint_details')
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
            // foreach($counts as $count){
            //     $res = [
            //         'totalCount' => $counts->TotalCount,
            //         'Solved' => $counts->Solved,
            //         'UnSolved' => $counts->UnSolved,
            //         'InProgress' => $counts->InProgress,
            //         'Hold' => $counts->Hold,
            //         'Queue' => $counts->Queue
            //         ];
            //     $result[] = $res;
            // }
    
            return response()->json([
            'code'=>200,
            'data'=>$counts,
            'message'=>'Count Fetched'
            ]);
        // return response()->json([
        //     'TotalCount' => $counts->TotalCount,
        //     'Solved' => $counts->Solved,
        //     'UnSolved' => $counts->UnSolved,
        //     'InProgress' => $counts->InProgress,
        //     'Hold' => $counts->Hold,
        //     'Queue' => $counts->Queue,
        // ]);
    }

    public function viewInvitationsCountsByDate($dateFrom, $dateTo)
    {
        $counts = DB::table('invitations')
            ->selectRaw('
                COUNT(id) as TotalCount,
                COUNT(CASE WHEN status = "NotMarked" THEN id END) as NotMarked,
                COUNT(CASE WHEN status = "NotAttended" THEN id END) as NotAttended,
                COUNT(CASE WHEN status = "Attended" THEN id END) as Attended
            ')
            ->where('isActive', 1)
            ->whereBetween('eventDate', [$dateFrom, $dateTo])
            ->first();

        return response()->json([
            'TotalCount' => $counts->TotalCount,
            'NotMarked' => $counts->NotMarked,
            'NotAttended' => $counts->NotAttended,
            'Attended' => $counts->Attended,
        ]);
    }
    
    public function viewInvitationsCounts()
    {
        $counts = DB::table('invitations')
            ->selectRaw('
                COUNT(id) as TotalCount,
                COUNT(CASE WHEN status = "Pending" THEN id END) as Pending,
                COUNT(CASE WHEN status = "Not Attended" THEN id END) as NotAttended,
                COUNT(CASE WHEN status = "Attended" THEN id END) as Attended
            ')
            ->where('isActive', 1)
            ->first();

        return response()->json([
            'TotalCount' => $counts->TotalCount,
            'Pending' => $counts->Pending,
            'NotAttended' => $counts->NotAttended,
            'Attended' => $counts->Attended,
        ]);
    }
    
    public function viewDevelopmentWorkDetailsCounts()
    {
        $counts = DB::table('development_work_details')
            ->selectRaw('
                COUNT(id) as totalCount,
                COUNT(CASE WHEN workStatus = "Proposed" THEN id END) as proposed,
                COUNT(CASE WHEN workStatus = "Solved" THEN id END) as solved,
                COUNT(CASE WHEN workStatus = "Inprogress" THEN id END) as inProgress,
                COUNT(CASE WHEN workStatus = "Hold" THEN id END) as hold
            ')
            ->where('isActive', 1)
            ->first();

        return response()->json([
            'code'=>200,
            'data'=>$counts,
            'message'=>'Data Fetched'
        ]);
    }
}
