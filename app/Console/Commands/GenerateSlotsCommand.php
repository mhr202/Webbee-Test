<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use Carbon\Carbon;
use App\Actions\GenerateSlots;

class GenerateSlotsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slots:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate time slots for services';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $services = Service::all();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        foreach ($services as $service) {
            $generateSlots = new GenerateSlots();
            $generateSlots->handle($service, $startDate, $endDate);
        }

        $this->info('Time slots generated successfully.');
    }

}
