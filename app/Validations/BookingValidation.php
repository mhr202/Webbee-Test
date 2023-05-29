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
            return response()->json(['errors' => $validator->errors()], 400);
        }



        // $validator->after(function ($validator) use ($data) {
        //     $service = Service::find($data['service_id']);
        //     $startTime = Carbon::createFromFormat('H:i', $data['start_time']);
        //     $endTime = Carbon::createFromFormat('H:i', $data['end_time']);
        //     $bookingDay = strtolower($data['day']);

        //     if (!$service->isSlotAvailable($startTime, $endTime, $bookingDay)) {
        //         $validator->errors()->add('slot_id', 'Requested slot is not available.');
        //     }

        //     if ($service->isSlotBookedOut($startTime, $endTime, $bookingDay)) {
        //         $validator->errors()->add('slot_id', 'Requested slot is booked out.');
        //     }

        //     if ($service->isSlotInBreak($startTime, $endTime, $bookingDay)) {
        //         $validator->errors()->add('slot_id', 'Requested slot falls between configured breaks.');
        //     }

        //     if ($service->isSlotInBreakBetweenAppointments($startTime, $endTime, $bookingDay)) {
        //         $validator->errors()->add('slot_id', 'Requested slot falls between configured break between appointments.');
        //     }

        //     if ($service->isPlannedOffDate($data['booking_time'], $startTime, $endTime)) {
        //         $validator->errors()->add('slot_id', 'Requested slot falls on a planned off date and time duration.');
        //     }

        //     $slot = Slot::find($data['slot_id']);
        //     if ($slot && !$slot->isAvailable()) {
        //         $validator->errors()->add('slot_id', 'Requested slot is not available.');
        //     }
        // });

        return null;
    }
}
