<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = ['duration', 'remaining_days'];

    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->status === 'Ended' || $this->status === 'Canceled') {
            return 0;
        }
        
        $today = Carbon::today();
        if ($today > $this->end_date) {
            return 0;
        }
        
        if ($today < $this->start_date) {
            return $this->duration;
        }
        
        return $today->diffInDays($this->end_date) + 1;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
