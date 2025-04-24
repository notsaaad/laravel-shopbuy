<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
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
      'type',
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

  public function categories()
  {
      return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
  }

  public $timestamps = true;
}
