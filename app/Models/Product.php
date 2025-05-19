<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model  {

	protected $fillable = [
        'code',
        'name',
        'price',
        'model',
        'description',
        'photo',
        'featured',
        'stock'
    ];
    public function basket()
{
    return $this->belongsToMany(Basket::class)->withPivot('quantity')->withTimestamps();
}

}