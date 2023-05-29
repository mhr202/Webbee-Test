<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\ServiceOff;
use App\Models\Service;
use Carbon\Carbon;
use App\Actions\GenerateSlots;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menService = Service::where('name', 'Men Haircut')->first();
        $womenService = Service::where('name', 'Women Haircut')->first();

        $slot = new GenerateSlots;
        $slot->handle($menService, Carbon::now(), Carbon::now()->addDays($menService->booking_time_limit));
        $slot->handle($womenService, Carbon::now(), Carbon::now()->addDays($womenService->booking_time_limit));
    }
}
