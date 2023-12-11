<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Validator;

class EventTypeController extends Controller
{
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'eventTypeName' => 'required | unique : eventypes',
            'created_by' => 'required',
        ]);
        if ($Validator->fails()) {
            return response()->json($Validator->errors()->tojson(), 400);
        }
        $eventType = EventType::create(array_merge($Validator->validated()));
        if ($eventType) {
            return response()->json([
                'code' => 200,
                'data' => $eventType,
                'message' => 'Event Type Added Successfully',
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'data' => [],
                'message' => 'Event Type Not Added',
            ]);
        }
    }
}
