<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeEvent extends Model
{
    //
    protected $fillable=['name','slug'];
    public $timestamps=false;

    public function events()
    {
    	return $this->hasMany(Event::class);
    }
}
