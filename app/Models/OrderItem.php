<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
class OrderItem extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table="order_items";
    protected $fillable = [
        'product_id',
        'quantity',
        'instruction',
    ];
    public function product()
    {
        return $this->hasone(Product::class, 'product_id', 'product_id');
    }
     public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
