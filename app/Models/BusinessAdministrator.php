<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAdministrator extends Model
{
    use HasFactory;
    protected $table = 'business_administrators';
    protected $fillable = ['name'];

    public function services()
    {
        return $this->hasMany(Service::class, 'business_administrator_id', 'id');
    }

}
