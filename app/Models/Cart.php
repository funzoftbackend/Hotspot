<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\OrderItem;
class Cart extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table="carts";
    protected $fillable = [
        'user_id',
        'order_ids',
        'subtotal ',
        'service_charges',
        'delivery_charges',
        'tax', 
        'tip', 
        'discount', 
        'promo_discount',
        'status', 
        'shipping_type',
        'net_price',
        'delivery_distance'
    ];
    public function user()
    {
        return $this->hasone(User::class, 'id', 'user_id');
    }
 
}
