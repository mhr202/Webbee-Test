<?php

namespace App\Http\Controllers;

use App\Actions\GenerateBookings;
use App\Validations\BookingValidation;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function create(Request $request, GenerateBookings $createBookingAction)
    {
        $bookingData = $request->input('bookings', []);
        $validationResponse = BookingValidation::validateBooking($bookingData);

        if ($validationResponse) {
            return $validationResponse;
        }

        $response = $createBookingAction->handle($bookingData);
        return $response;
    }
}
