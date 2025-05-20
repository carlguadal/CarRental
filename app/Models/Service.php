<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'servicename',
        'description',
        'price',
        'reduce',
        'stars',
        'status',
        'image'
    ];
}