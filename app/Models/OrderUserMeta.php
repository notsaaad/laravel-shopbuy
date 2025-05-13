<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderUserMeta extends Model
{
    use HasFactory;
        protected $fillable = [
        'order_id', 'name', 'email', 'phone',
        'country', 'city', 'address', 'postal_code',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
