<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOff extends Model
{
    use HasFactory;
    protected $table = 'service_offs';
    protected $fillable = ['name', 'start', 'end'];    

    public function service() {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

}
