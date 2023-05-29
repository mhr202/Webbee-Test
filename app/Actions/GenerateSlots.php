<?php

namespace App\Actions;

use App\Models\Slot;
use App\Models\Service;
use App\Models\ServiceBreak;
use App\Models\ServiceOff;
use App\Models\ServiceWorkingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class GenerateSlots
{
    public function handle(Service $service, Carbon $startDate, Carbon $endDate)
    {
        $currentDate = $startDate->copy();

        while ($currentDate->lt($endDate)) {
            $times = $this->getOpeningClosingTime($service, $currentDate);
            if ($times !== null) {
                $openingTime = $times[0]
                    ->copy()
                    ->setYear($currentDate->format('Y'))
                    ->setMonth($currentDate->format('m'))
                    ->setDay($currentDate->format('d'));
                $closingTime = $times[1]
                    ->copy()
                    ->setYear($currentDate->format('Y'))
                    ->setMonth($currentDate->format('m'))
                    ->setDay($currentDate->format('d'));
                $updatedTimes = $this->isValidBookingDay($service, $currentDate, $openingTime, $closingTime);

                if ($updatedTimes !== null) {
                    $this->generateSlotsForTimeRange($service, $openingTime, $closingTime, $currentDate);
                }
            }
            $currentDate->addDay();
        }
    }

    private function generateSlotsForTimeRange(Service $service, Carbon $openingTime, Carbon $closingTime, Carbon $date)
    {
        $currentTime = $openingTime->copy();

        while ($currentTime->copy()->addMinutes($service->slot_duration)->lt($closingTime)) {
            if (!$this->isBreakTime($service, $currentTime, $date, $service->slot_duration)) {
                $this->createSlot($service, $currentTime);
            }

            $currentTime->addMinutes($service->after_service_time);
        }
    }

    private function createSlot(Service $service, Carbon $currentTime)
    {
        $slot = new Slot();
        $slot->service_id = $service->id;
        $slot->date = $currentTime->toDatestring();
        $slot->start_time = $currentTime->toDateTimeString();
        $slot->end_time = $currentTime->copy()->addMinutes($service->slot_duration)->toDateTimeString();
        $slot->capacity = $service->capacity;
        $slot->save();
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
                return null;
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
                    Carbon::parse($working->end_time),
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
