<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Slot;
use App\Models\Service;

class GenerateBookings
{
    public function handle(array $bookingData)
    {
        foreach ($bookingData as $bookingItem) {
            $startTime = $bookingItem['start_time'];
            $endTime = $bookingItem['end_time'];
            $day = $bookingItem['day'];
            $serviceName = $bookingItem['service_name'];
            $firstName = $bookingItem['first_name'];
            $lastName = $bookingItem['last_name'];
            $email = $bookingItem['email'];

            $service = Service::where('name', $serviceName)->first();

            if (!$service) {
                return response()->json(['message' => 'Service not found'], 404);
            }

            $slot = Slot::where('date', $day)
                ->where('start_time', $startTime)
                ->where('end_time', $endTime)
                ->where('service_id', $service->id)
                ->where('capacity', '>', 0)
                ->whereDate('date', '=', $day)
                ->first();
            
            if (!$slot) {
                return response()->json(['message' => 'Requested slot not available'], 400);
            }

            if ($slot->capacity == 0) {
                return response()->json(['message' => 'Requested slot is already booked'], 400);
            }

            $booking = new Booking();
            $booking->user_first_name = $firstName;
            $booking->user_last_name = $lastName;
            $booking->user_email = $email;
            $booking->slot_id = $slot->id;
            $booking->save();

            $slot->decrement('capacity');
        }

        return response()->json(['message' => 'Bookings created successfully'], 201);

    }
}
