<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAddress;
class CommunityPost extends Authenticatable
{
    protected $table="community_posts";
    protected $fillable = [
        'creator_id',
        'post_text',
        'post_epoch_date',
        'post_media_urls',
        'post_hash_tags'
    ];
}
