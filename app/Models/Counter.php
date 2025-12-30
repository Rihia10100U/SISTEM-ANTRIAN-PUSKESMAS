<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = [
        'name', 'service_id', 'is_active',
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
