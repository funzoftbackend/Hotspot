<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAddress;
class CommunityComment extends Authenticatable
{
    protected $table="community_comments";
    protected $fillable = [
        'commentor_id',
        'comment_text',
        'comment_epoch_date',
        'comment_hashtags',
        'review_id',
        'post_id'
    ];
}
