<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'logo',
        'address',
        'status',
        'total_users',
        'clock_in_time',
        'clock_out_time',
        'early_clock_in_time',
        'allow_clock_out_till',
        'self_clocking',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'clock_in_time' => 'datetime:H:i:s',
        'clock_out_time' => 'datetime:H:i:s',
        'self_clocking' => 'boolean',
    ];

    /**
     * The default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'active',
        'total_users' => 1,
        'clock_in_time' => '08:00:00',
        'clock_out_time' => '17:00:00',
        'self_clocking' => true,
    ];
}
