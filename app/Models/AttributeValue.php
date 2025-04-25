<?php

namespace App\Models;

use App\Models\Attribute;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
    use HasFactory;
    protected $fillable = ['attribute_id', 'value', 'color_code', 'image_path'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'variant_attribute_value');
    }
}
