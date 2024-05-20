<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use Notifiable;
    protected $table = "driver";
    protected $fillable = [
        'email',
        'phone_number',
        'first_name',
        'last_name',
        'select_island',
        'latitude',
        'longitude',
        'vehicle_make',
        'vehicle_model',
        'vehicle_color',
        'vehicle_model_year',
        'vehicle_license_plate',
        'license_front',
        'license_back',
        'image',
        'availability',
        'passcode',
        'password',
    ];
}
