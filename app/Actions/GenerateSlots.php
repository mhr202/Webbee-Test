<?php

namespace App\Actions;

use App\Models\Slot;
use App\Models\Service;
use App\Models\ServiceBreak;
use App\Models\ServiceOff;
use App\Models\ServiceWorkingDay;
use Carbon\Carbon;

class GenerateSlots
{
    public function handle(Service $service, Carbon $startDate, Carbon $endDate)
    {
        $currentDate = $startDate->copy();

        while ($currentDate->lt($endDate)) {
            $times = $this->getOpeningClosingTime($service, $currentDate);
            if ($times !== null) {
                $openingTime = $times[0]
                    ->setYear($currentDate->format('Y'))
                    ->setMonth($currentDate->format('m'))
                    ->setDay($currentDate->format('d'));
                $closingTime = $times[1]
                    ->setYear($currentDate->format('Y'))
                    ->setMonth($currentDate->format('m'))
                    ->setDay($currentDate->format('d'));
                $updatedTimes = $this->isValidBookingDay($service, $currentDate, $openingTime, $closingTime);
                if ($updatedTimes !== null) {
                    $openingTime = $updatedTimes[0];
                    echo ($updatedTimes[0]);
                    $closingTime = $updatedTimes[1];
                    $currentTime = $openingTime->copy();

                    while ($currentTime->copy()->addMinutes($service->slot_duration)->lt($closingTime)) {
                        if (!$this->isBreakTime($service, $currentTime, $currentDate, $service->slot_duration)) {
                            $slot = new Slot();
                            $slot->service_id = $service->id;
                            $slot->date = $currentTime->toDatestring();
                            $slot->start_time = $currentTime->toDateTimeString();
                            $slot->end_time = $currentTime->addMinutes($service->slot_duration)->toDateTimeString();
                            $slot->capacity = $service->capacity;
                            $slot->save();
                        }

                        $currentTime->addMinutes($service->after_service_time);
                    }
                }
            }
            $currentDate->addDay();
        }
    }

    private function isValidBookingDay(Service $service, Carbon $date, Carbon $openingTime, Carbon $closingTime)
    {
        $bookingDay = $date->format('l');
        $workingDays = ServiceWorkingDay::where('service_id', $service->id)->get();
        $countDays = 0;

        foreach ($workingDays as $working) {
            if ($working->day == $bookingDay) {
                $countDays++;
            }
        }

        if ($countDays === 0) {
            return null;
        }

        $offDays = ServiceOff::where('service_id', $service->id)->get();

        foreach ($offDays as $off) {
            if (Carbon::parse($off->start)->isSameDay($openingTime)) {
                if (!$off->is_half_day) {
                    return null;
                }
                else {
                    if (Carbon::parse($openingTime)->lte(Carbon::parse($off->start)) && Carbon::parse($openingTime)->lte(Carbon::parse($off->end)) && Carbon::parse($closingTime)->gte(Carbon::parse($off->start)) && Carbon::parse($closingTime)->lte(Carbon::parse($off->end))) {
                        $closingTime = Carbon::parse($off->start);
                        break;
                    }
                    else {
                        $openingTime = Carbon::parse($off->end);
                        break;
                    }
                }
            }
        }

        return [$openingTime, $closingTime];
    }

    private function getOpeningClosingTime(Service $service, Carbon $date)
    {
        $bookingDay = $date->format('l');
        $workingDays = ServiceWorkingDay::where('service_id', $service->id)->get();

        foreach ($workingDays as $working) {
            if ($working->day == $bookingDay) {
                return [
                    Carbon::parse($working->start_time),
                    Carbon::parse($working->end_time)
                ];
            }
        }

        return null;
    }

    private function isBreakTime(Service $service, Carbon $time, Carbon $date, $slotTime)
    {
        $breakTimes = ServiceBreak::where('service_id', $service->id)->get();
        $date = Carbon::parse($date);
        $time = Carbon::parse($time);

        foreach ($breakTimes as $breakTime) {
            $startTime = Carbon::parse($breakTime->start_time)
                ->setYear($date->format('Y'))
                ->setMonth($date->format('m'))
                ->setDay($date->format('d'));
            $endTime = Carbon::parse($breakTime->end_time)
                ->setYear($date->format('Y'))
                ->setMonth($date->format('m'))
                ->setDay($date->format('d'));

            if ($time->between($startTime, $endTime) || ($time->lt($startTime) && $time->copy()->addMinutes($slotTime)->gt($startTime))) {
                return true;
            }
        }

        return false;
    }
}
