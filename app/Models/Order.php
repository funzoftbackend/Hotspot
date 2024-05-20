<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Cart;
class Order extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table="orders";
    protected $fillable = [
        'cart_id',
        'min_time',
        'max_time',
        'delivery_stage',
        'order_date',
        'order_status',
        'vendor_id',
        'buyer_id',
        'driver_id',
        'driver_distance',
        'driver_payment',
    ];
    public function cart()
    {
        return $this->hasone(Cart::class, 'id', 'cart_id');
    }
}
