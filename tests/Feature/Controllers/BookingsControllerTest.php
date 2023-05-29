<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;
use App\Models\Slot;

class BookingsControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testCreateBookings_Success()
    {
        $slot = Slot::factory()->create();

        $bookingData = '{
          "bookings": [
            {
              "start_time" : "10:00:00",
              "end_time" : "12:00:00",
              "day" : "2023-05-30",
              "service_name" : "Service 1",
              "first_name" : "John",
              "last_name" : "Doe",
              "email" : "johndoe@example.com"
            }
          ]
        }';
        
        $response = $this->json('POST', '/api/bookings',  ['bookings' => json_decode($bookingData, true)['bookings']]);
        
        $response->assertStatus(201);
        
        $response->assertJson([
            'message' => 'All bookings created successfully',
            'successful_bookings' => [
                [
                    'user_first_name' => 'John',
                    'user_last_name' => 'Doe',
                    'user_email' => 'johndoe@example.com',
                    'slot_id' => $slot->id
                ]
            ]
        ]);
        
        $this->assertDatabaseHas('bookings', [
            'user_first_name' => 'John',
            'user_last_name' => 'Doe',
            'user_email' => 'johndoe@example.com',
            'slot_id' => $slot->id
        ]);
        
        $this->assertDatabaseHas('slots', [
            'id' => $slot->id,
            'capacity' => 0
        ]);
    }
    
    public function testCreateBookings_WithErrors()
    {
        $service = Service::factory()->create();
        
        $bookingData = '{
          "bookings": [
            {
              "start_time" : "10:00:00",
              "end_time" : "12:00:00",
              "day" : "2023-05-30",
              "service_name" : "Nonexistent Service",
              "first_name" : "John",
              "last_name" : "Doe",
              "email" : "johndoe@example.com"
            }
          ]
        }';
        
        $response = $this->json('POST', '/api/bookings', ['bookings' => json_decode($bookingData, true)['bookings']]);
        
        $response->assertStatus(400);
        
        $response->assertJson([
            'message' => 'Some bookings failed',
            'errors' => ['Service not found'],
            'successful_bookings' => [],
            'failed_bookings' => [
                [
                    'start_time' => '10:00:00',
                    'end_time' => '12:00:00',
                    'day' => '2023-05-30',
                    'service_name' => 'Nonexistent Service',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'johndoe@example.com'
                ]
            ]
        ]);
        
        $this->assertDatabaseCount('bookings', 0);
    }
}
