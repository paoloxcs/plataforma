<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = ['url_image','thumbnail','is_main','product_id'];
    public $timestamps = false;

    // Relación con producto | Tipo: N a 1
    public function product()
    {
    	return $this->belongsTo(Product::class,'product_id');
    }

    // Mutador para el atributo url_image
    public function getUrlImageAttribute($value)
    {
        if($value) return url('/').'/images/products/'.$value;
        return url('/').'/images/default.jpg';
    }

    // Mutador para el atributo thumbnail
    public function getThumbnailAttribute($value)
    {
        if($value) return url('/').'/images/thumbnails/'.$value;
        return url('/').'/images/default.jpg';
    }
}
