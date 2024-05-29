<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAddress;
class Favourite extends Authenticatable
{
    protected $table="review_post_favourites";
    protected $fillable = [
        'review_id',
        'post_id',
        'comment_id',
        'is_favourite'
    ];
}
