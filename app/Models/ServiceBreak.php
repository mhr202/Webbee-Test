<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBreak extends Model
{
    use HasFactory;
    protected $table = 'service_breaks';
    protected $fillable = ['name', 'start_time', 'end_time'];  

    public function service() {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

}
