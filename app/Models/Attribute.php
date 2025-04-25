<?php

namespace App\Models;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'display_type'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
