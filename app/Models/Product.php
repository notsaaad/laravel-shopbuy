<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'price',
        'sale',
        'image',
        'is_draft',
        'description',
        'type',
        'stock',
        'gallary',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The attributes that should be appended to the model's array and JSON forms.
     *
     * @var array
     */


    protected $casts = [
      'gallery' => 'array',
  ];

    public $timestamps = true;

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
    protected $appends = ['formatted_variants'];
    // Accessor for formatted_variants
    public function getFormattedVariantsAttribute()
    {
        if ($this->type !== 'variant') {
            return null;
        }

        // تأكد من تحميل العلاقات المطلوبة
        $this->loadMissing('variants.attributeValues.attribute');

        $variantData = [];

        foreach ($this->variants as $variant) {
            $attributes = [];

            foreach ($variant->attributeValues as $attrVal) {
                $attributes[] = [
                    'attribute'   => $attrVal->attribute->name,
                    'value'       => $attrVal->value,
                    'color_code'  => $attrVal->color_code,
                    'image_path'  => $variant->image_path, // مضافة هنا لكل attribute
                ];
            }

            $variantData[$variant->id] = [
                'attributes'  => $attributes,
                'stock'       => $variant->stock,
                'image_path'  => $variant->image_path, // وهنا كمان نضيفها للـ variant نفسه
            ];
        }

        return $variantData;
    }

}
