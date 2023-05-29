<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceBreak;
use Carbon\Carbon;

class ServiceBreakSeeder extends Seeder
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

        $startLunch = Carbon::createFromTime(12,0,0);
        $endLunch = Carbon::createFromTime(13,0,0);
        $startClean = Carbon::createFromTime(15,0,0);
        $endClean = Carbon::createFromTime(16,0,0);

        $menService->breaks()->create([
            'name' => 'Lunch Break',
            'start_time' => $startLunch,
            'end_time' => $endLunch
        ]);

        $menService->breaks()->create([
            'name' => 'Cleaning Break',
            'start_time' => $startClean,
            'end_time' => $endClean
        ]);

        $womenService->breaks()->create([
            'name' => 'Lunch Break',
            'start_time' => $startLunch,
            'end_time' => $endLunch
        ]);

        $womenService->breaks()->create([
            'name' => 'Cleaning Break',
            'start_time' => $startClean,
            'end_time' => $endClean
        ]);
    }
}
