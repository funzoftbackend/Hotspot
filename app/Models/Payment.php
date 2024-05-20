<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'cart_id', 'payment_details'
    ];

}
