<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Http\Resources\SlotResource;
use App\Models\Service;

class SlotsController extends Controller
{
    public function index($serviceId)
    {
        
        $service = Service::where('id', $serviceId)->first();

        if (!$service) {
            return response()->json(['message' => 'No service found with this ID.'], 404);
        } 

        $endDate = now()->addDays($service->booking_time_limit)->endOfDay(); //
        
        $slots = Slot::where('service_id', $serviceId)
                    ->where('capacity', '>', 0)
                    ->where('date', '<=', $endDate)
                 ->get();

        if ($slots->isEmpty()) {
            return response()->json(['message' => 'No slots found for the specified service.'], 404);
        }
        
        return SlotResource::collection($slots);
    }

}
