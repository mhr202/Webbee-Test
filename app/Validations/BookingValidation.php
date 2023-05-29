<?php

namespace App\Validations;

use App\Models\Service;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BookingValidation
{
    public static function validateBooking(array $data)
    {
        // echo ("dkfdjh");
        $validator = Validator::make($data, [
            'bookings.*.start_time' => 'required|date_format:H:i',
            'bookings.*.end_time' => 'required|date_format:H:i',
            'bookings.*.day' => 'required|date',
            'bookings.*.service_name' => 'required|string',
            'bookings.*.first_name' => 'required|string',
            'bookings.*.last_name' => 'required|string',
            'bookings.*.email' => 'required|email',
        ]);

        if ($validator->fails()) {
            echo ("dkfdjh");
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return null;
    }
}
