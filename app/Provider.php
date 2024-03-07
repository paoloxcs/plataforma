<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
	protected $fillable = ['name','slug','assoc_email','description','url_web','address','phone_number','url_logo','url_portada','status','whatsapp_number','url_google_maps'];

	//Realación con usuarios | Tipo: N a N
	public function users()
	{
		return $this->belongsToMany(User::class, 'providers_users');
	}

	// Relación con productos | Tipo: 1 a N
	public function products()
	{
		return $this->hasMany(Product::class);
	}

	// Relación con catalogos | Tipo: N a N
	public function catalogs()
	{
		return $this->belongsToMany(Catalog::class,'catalogs_providers');
	}

	// Relación con telefonos extra | Tipo: 1 a N
	public function phones()
	{
		return $this->hasMany(ProviderPhone::class);
	}

	// Relación con direcciones extra | Tipo: 1 a N
	public function addresses()
	{
		return $this->hasMany(ProviderAddress::class);
	}

	// Relación con clicks | Tipo: 1 a N
	public function clicks()
	{
		return $this->hasMany(ProviderClick::class);
	}

	// Mutador para el atributo url_logo
	public function getUrlLogoAttribute($value)
	{
		if($value) return url('/').'/images/providers/'.$value;
		return url('/').'/images/default.jpg';
	}

	// Mutador para el atributo url_portada
	public function getUrlPortadaAttribute($value)
	{
		if($value) return url('/').'/images/providers/'.$value;

		$catalog_sigla = request()->header('catalog-client');
		return url('/').'/images/default/'.strtolower($catalog_sigla).'.jpg';
	}

	// Auditar productos del proveedor segun estado
	// Es invocado cuando se actualiza un registro.
	public function audit_products()
	{
		if($this->status == 1){
			$this->products()->update(['enabled' => true]);
		}else{
			$this->products()->update(['enabled' => false]);
		}
	}

	
}
