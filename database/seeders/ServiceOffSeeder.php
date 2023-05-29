<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceOff;
use App\Models\Service;
use Carbon\Carbon;
use App\Actions\GenerateSlots;

class ServiceOffSeeder extends Seeder
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

        $start = Carbon::now()->addDays(2)->setHour(0)->setMinute(0)->setSecond(0);
        $end = Carbon::now()->addDays(2)->setHour(23)->setMinute(59)->setSecond(59);


        $start1 = Carbon::now()->addDays(3)->setHour(14)->setMinute(0)->setSecond(0);
        $end1 = Carbon::now()->addDays(3)->setHour(23)->setMinute(59)->setSecond(59);

        $menService->offs()->create([
            'name' => 'Default Off',
            'start' => $start,
            'end' => $end,
        ]);

        $menService->offs()->create([
            'name' => 'Default Off',
            'start' => $start1,
            'end' => $end1,
            'is_half_day' => true,
        ]);

        $womenService->offs()->create([
            'name' => 'Default Off',
            'start' => $start,
            'end' => $end,
        ]);
    }
}
