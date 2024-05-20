<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserAddress extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $table = 'user_addresses';
    protected $fillable = [
        'address',
        'user_id',
        'title',
        'latitude',
        'longitude',
    ];
      public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
