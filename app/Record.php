<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['user_id','gestor_id','body'];

    public function gestor()
    {
    	return $this->belongsTo(User::class,'gestor_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
