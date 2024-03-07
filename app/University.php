<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    //
    protected $table = "universities"; 
    protected $fillable = ['user_id', 'name', 'created_at', 'updated_at'];

    //Relacion uno a muchos inversa

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
