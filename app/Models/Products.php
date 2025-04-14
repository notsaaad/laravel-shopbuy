<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
      'category_id',
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

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public $timestamps = true;
}
