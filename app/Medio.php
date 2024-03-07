<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medio extends Model
{
    protected $fillable =['name','sigla'];
    public $timestamps = false;

    public function intereses()
    {
    	return $this->hasMany(Interes::class);
    }
}
