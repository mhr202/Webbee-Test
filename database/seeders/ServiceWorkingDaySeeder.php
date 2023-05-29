<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceWorkingDay;
use Carbon\Carbon;

class ServiceWorkingDaySeeder extends Seeder
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
        $workingDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $startNormal = Carbon::createFromTime(8,0,0);
        $endNormal = Carbon::createFromTime(20,0,0);
        $startSat = Carbon::createFromTime(10,0,0);
        $endSat = Carbon::createFromTime(22,0,0);
        
        foreach($workingDays as $key => $d) {
            if($d != 'Saturday') {
                $menService->days()->create([
                    'day' => $d,
                    'start_time' => $startNormal,
                    'end_time' => $endNormal,
                ]);
            }
            else {
                $menService->days()->create([
                    'day' => $d,
                    'start_time' => $startSat,
                    'end_time' => $endSat,
                ]);
            }
        }

       foreach($workingDays as $key => $d) {
            if($d != 'Saturday') {
                $womenService->days()->create([
                    'day' => $d,
                    'start_time' => $startNormal,
                    'end_time' => $endNormal,
                ]);
            }
            else {
                $womenService->days()->create([
                    'day' => $d,
                    'start_time' => $startSat,
                    'end_time' => $endSat,
                ]);
            }
        }

    }
}
