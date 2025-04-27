<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
      'variant_id',
      'attribute_value_id',
  ];

  // لو الجدول اسمه مختلف عن plural للموديل، عرفه كده:
  protected $table = 'variant_attribute_value'; // أو 'variant_attribute_values' حسب التسمية

  public $timestamps = true; // لو بتستخدم created_at و updated_at
}
