<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Search extends Authenticatable
{
    use HasFactory, Notifiable;
     protected $table = 'searches';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'search_text',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

}
