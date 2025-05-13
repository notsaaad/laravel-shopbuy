<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_title',
        'product_image',
        'variant_attributes',
        'unit_price',
        'quantity',
        'total_price',
    ];

    protected $casts = [
        'variant_attributes' => 'array',
    ];

    // العلاقة مع الطلب الرئيسي
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
