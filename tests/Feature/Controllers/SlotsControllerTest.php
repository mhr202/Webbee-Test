<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;
use App\Models\Slot;

class SlotsControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function testIndex_ReturnsSlotsForService()
    {        
        $slots = Slot::factory()->create();

        $response = $this->get("/api/slots/$slots->service_id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'capacity',
                    'start_time',
                    'end_time',
                    'day'
                ]
            ]
        ]);
        
        $response->assertJsonCount($slots->count(), 'data');
        $response->assertJsonFragment([
            'capacity' => 1,
        ]);
    }
    
    public function testIndex_ReturnsNotFoundForInvalidService()
    {
        $response = $this->get("/api/slots/1234");
        
        $response->assertStatus(404);
        
        $response->assertJson([
            'message' => 'No service found with this ID.',
        ]);
    }
    
}
