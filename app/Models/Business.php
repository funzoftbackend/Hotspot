<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name', 'email', 'user_id','phone', 'location','latitude','longitude','delivery', 'pickup', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'business_status', 'business_image', 'logo_image', 'promo_images', 'category_id', 'rating', 'delivery_time'
    ];

    public function update_hotspot(Request $request, $id)
    {
        $business = Business::find($id);
        if (!$business) {
            return response()->json(['message' => 'Business not found'], 404);
        }

        $business->update($request->all());
        return response()->json($business, 200);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function create_hotspot(Request $request)
    {
        $business = Business::create($request->all());
        return response()->json($business, 201);
    }
}
