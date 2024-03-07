<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = ['name','url_redirect','sigla','associated_email','reference_color','url_log'];
    public $timestams = false;

    // Relación con proveedores | Tipo: N a N
    public function providers()
    {
    	return $this->belongsToMany(Provider::class,'catalogs_providers');
    }

    // Relación con productos | Tipo: N a N
    public function products()
    {
    	return $this->belongsToMany(Product::class,'catalogs_products');
    }

    // Relación con rubros | Tipo: N a N
    public function items()
    {
        return $this->belongsToMany(Item::class, 'catalogs_items');
    }

    // Relación con slides | Tipo: N a N
    public function slides()
    {
        return $this->belongsToMany(Slide::class,'catalogs_slides');
    }

    // Relación con posts | Tipo: N a N
    public function posts()
    {
        return $this->belongsToMany(Post::class,'catalogs_posts');
    }
     // Relación con posts | Tipo: N a N
    public function videos()
    {
        return $this->belongsToMany(Video::class,'catalogs_videos');
    }

    // Relación con cotizaciones | Tipo: 1 a N
    public function product_quotes()
    {
        return $this->hasMany(ProductQuote::class);
    }
}
