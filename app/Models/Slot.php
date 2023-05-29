<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;
    protected $table = 'slots';
    protected $fillable = ['start_time', 'end_time', 'date'];  

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function slot() {
        return $this->beloingsTo(Slot::class, 'slot_id', 'id');
    }

}

