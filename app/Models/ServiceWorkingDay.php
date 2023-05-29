<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceWorkingDay extends Model
{
    use HasFactory;
    protected $table = 'service_working_days';
    protected $fillable = ['day', 'start_time', 'end_time'];    

    public function service() {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

}
