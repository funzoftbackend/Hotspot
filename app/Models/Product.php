<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class Product extends Model
{
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'business_id', 'name', 'details', 'price', 'discount', 'image_url', 'availability', 'available_sizes'
    ];

    public function create_product(array $data)
    {
        $validator = Validator::make($data, [
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required',
            'details' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable',
            'image_url' => 'nullable|url',
            'availability' => 'required|boolean',
            'available_sizes' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()->first()];
        }

        $product = $this->create($data);
        return ['success' => true, 'message' => 'Product created successfully', 'data' => $product];
    }
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
      public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function update_product(int $id, array $data)
    {
        $product = $this->find($id);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        $validator = Validator::make($data, [
            'business_id' => 'required|exists:businesses,id',
            'name' => 'required',
            'details' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable',
            'image_url' => 'nullable|url',
            'availability' => 'required|boolean',
            'available_sizes' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()->first()];
        }

        $product->update($data);
        return ['success' => true, 'message' => 'Product updated successfully', 'data' => $product];
    }
}
