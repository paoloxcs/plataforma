<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interes extends Model
{
    protected $table ='intereses';

    protected $fillable =['user_id','medio_id','is_main'];

    public function medio()
    {
    	return $this->belongsTo(Medio::class,'medio_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
