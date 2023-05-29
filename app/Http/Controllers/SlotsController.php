<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Http\Resources\SlotResource;
class SlotsController extends Controller
{
    public function index($serviceId)
    {
        $slots = Slot::where('service_id', $serviceId)
                 ->where('capacity', '>', 1)
                 ->get();

        if ($slots->isEmpty()) {
            return response()->json(['message' => 'No slots found for the specified service.'], 404);
        }
        
        return SlotResource::collection($slots);
    }

}
