<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bookings.*.start_time' => 'required|date_format:H:i',
            'bookings.*.end_time' => 'required|date_format:H:i',
            'bookings.*.day' => 'required|date',
            'bookings.*.service_name' => 'required|string',
            'bookings.*.first_name' => 'required|string',
            'bookings.*.last_name' => 'required|string',
            'bookings.*.email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'bookings.required' => 'The bookings field is required.',
            'bookings.array' => 'The bookings field must be an array.',
            'bookings.*.start_time.required' => 'The start time is required for all bookings.',
            'bookings.*.start_time.date_format' => 'The start time must be in the format H:i.',
            'bookings.*.end_time.required' => 'The end time is required for all bookings.',
            'bookings.*.end_time.date_format' => 'The end time must be in the format H:i.',
            'bookings.*.day.required' => 'The day is required for all bookings.',
            'bookings.*.day.date' => 'The day must be a valid date.',
            'bookings.*.service_name.required' => 'The service name is required for all bookings.',
            'bookings.*.service_name.string' => 'The service name must be a string.',
            'bookings.*.first_name.required' => 'The first name is required for all bookings.',
            'bookings.*.first_name.string' => 'The first name must be a string.',
            'bookings.*.last_name.required' => 'The last name is required for all bookings.',
            'bookings.*.last_name.string' => 'The last name must be a string.',
            'bookings.*.email.required' => 'The email is required for all bookings.',
            'bookings.*.email.email' => 'The email must be a valid email address.',
        ];
    }
}
