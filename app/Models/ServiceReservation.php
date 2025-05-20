<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'scheduled_date',
        'notes',
        'status',
        'payment_status'
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
} 