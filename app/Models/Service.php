<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory; 
    protected $table = 'services';
    protected $fillable = ['name', 'slot_duration', 'capacity', 'after_service_time', 'booking_time_limit'];

    public function days() {
        return $this->hasMany(ServiceWorkingDay::class, 'service_id', 'id');
    }

    public function offs() {
        return $this->hasMany(ServiceOff::class, 'service_id', 'id');
    }

    public function breaks() {
        return $this->hasMany(ServiceBreak::class, 'service_id', 'id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'service_id', 'id');
    }
}
