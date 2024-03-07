<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ejecutivo extends Model
{
	protected $primaryKey = 'idejecutivo';
    protected $fillable =['nombres','apellidos'];

    public function clientes()
    {
    	return $this->belongsToMany(Cliente::class, 'clientes_ejecutivos','ejecutivo_id');
    }
}
