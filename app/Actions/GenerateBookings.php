<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Slot;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GenerateBookings
{
    private $errors;

    public function handle(array $bookingData)
    {
        $this->errors = new Collection();
        $successfulBookings = [];
        $failedBookings = [];

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
                $this->addError('Service not found');
                $failedBookings[] = $bookingItem;
                continue;
            }

            $slot = $this->findAvailableSlot($service, $day, $startTime, $endTime);

            if (!$slot) {
                $this->addError('Requested slot not available');
                $failedBookings[] = $bookingItem;
                continue;
            }

            if ($slot->capacity == 0) {
                $this->addError('Requested slot is already booked');
                $failedBookings[] = $bookingItem;
                continue;
            }

            if ($this->isBookingTimeExpired($day, $service->booking_time_limit)) {
                $this->addError('Booking slots are not available after the specific time period');
                $failedBookings[] = $bookingItem;
                continue;
            }

            $booking = $this->createBooking($firstName, $lastName, $email, $slot);
            $this->updateSlotCapacity($slot);

            if ($booking) {
                $successfulBookings[] = $booking;
            } else {
                $failedBookings[] = $bookingItem;
            }
        }

        if (!empty($failedBookings)) {
            return response()->json([
                'message' => 'Some bookings failed',
                'errors' => $this->errors,
                'successful_bookings' => $successfulBookings,
                'failed_bookings' => $failedBookings
            ], 400);
        }

        return response()->json([
            'message' => 'All bookings created successfully',
            'successful_bookings' => $successfulBookings
        ], 201);
    }

    private function addError($message)
    {
        $this->errors->push($message);
    }

    private function findAvailableSlot($service, $day, $startTime, $endTime)
    {
        return Slot::where('date', $day)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->where('service_id', $service->id)
            ->where('capacity', '>', 0)
            ->whereDate('date', '=', $day)
            ->first();
    }

    private function isBookingTimeExpired($day, $bookingTimeLimit)
    {
        return Carbon::parse($day)->gt(Carbon::now()->addDays($bookingTimeLimit));
    }

    private function createBooking($firstName, $lastName, $email, $slot)
    {
        $booking = new Booking();
        $booking->user_first_name = $firstName;
        $booking->user_last_name = $lastName;
        $booking->user_email = $email;
        $booking->slot_id = $slot->id;
        $booking->save();

        return $booking;
    }

    private function updateSlotCapacity($slot)
    {
        $slot->decrement('capacity');
    }
}
