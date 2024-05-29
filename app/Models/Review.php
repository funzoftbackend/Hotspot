<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAddress;
class Review extends Authenticatable
{
    protected $table="reviews";
    protected $fillable = [
        'business_id',
        'creator_id',
        'reviews_text',
        'reviews_rating',
        'epoch_date',
        'media_urls',
        'reviews_hashtags'
    ];
}
