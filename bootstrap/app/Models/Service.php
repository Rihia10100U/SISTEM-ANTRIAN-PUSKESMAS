<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <--- PENTING: Import ini

class Service extends Model
{
    protected $fillable = ['name', 'prefix', 'padding', 'is_active'];

    /**
     * Relasi: Satu Layanan (Service) memiliki banyak Antrian (Queues)
     */
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class);
    }
}