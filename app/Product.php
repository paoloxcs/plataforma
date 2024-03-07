<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{   
    /*26/08/2020
    Se agrego columnas 'price','min_stock','stock'
    price: int (precio real * 100)
    min_stock: int (puede ser 0)
    stock: int 
    */

    protected $fillable = ['name','slug','description','details','provider_id','brand_id','sub_category_id','enabled','price','min_stock','stock','fair_price','descuento','orden'];


    // Relación con proveedor | Tipo: N a 1
    public function provider()
    {
    	return $this->belongsTo(Provider::class,'provider_id');
    }

    // Relación con marca | Tipo: N a 1
    public function brand()
    {
    	return $this->belongsTo(Brand::class,'brand_id');
    }

    // Relación con subcategoría | Tipo: N a 1
    public function sub_category()
    {
    	return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    // Relación con catalogos | Tipo: N a N
    public function catalogs()
	{
		return $this->belongsToMany(Catalog::class,'catalogs_products');
	}
    
    // Relación con tags | Tipo: N a N
    public function tags()
    {
    	return $this->belongsToMany(Tag::class, 'products_tags');
    }

    // Relación con opciones | Tipo: 1 a 1
    public function product_option()
    {
    	return $this->hasOne(ProductOption::class);
    }

    // Relación con recursos pdf | Tipo: 1 a N
    public function product_resources()
    {
    	return $this->hasMany(ProductResource::class);
    }

    // Relación con fotos | Tipo: 1 a N
    public function product_images()
    {
    	return $this->hasMany(ProductImage::class);
    }

    // Relación con cotizaciones | Tipo: 1 a N
    public function product_quotes()
    {
        return $this->hasMany(ProductQuote::class);
    }

    // Relación con clicks | Tipo: 1 a N
    public function clicks()
    {
        return $this->hasMany(ProductClick::class);
    }
     public function bim()
    {
        return $this->hasMany(Bim::class);
    }
}
