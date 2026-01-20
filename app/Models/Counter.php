<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Counter extends Model
{
    protected $fillable = [
        'name', 'service_id', 'is_active',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relasi untuk mendapatkan SATU antrian yang sedang aktif di loket ini.
     */
    public function activeQueue(): HasOne
    {
        // Logic: Ambil satu antrian yang milik counter ini,
        // yang statusnya BUKAN 'waiting', 'finished', atau 'canceled'.
        // Atau ambil yang paling terakhir diupdate (latestOfMany).

        return $this->hasOne(Queue::class)
            ->whereIn('status', ['called', 'serving']) // Sesuaikan status "Aktif" menurut aplikasi Anda
            ->latestOfMany();
    }
}
