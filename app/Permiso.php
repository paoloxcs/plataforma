<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $fillable =['name','slug'];

    public $timestamps =false;

    public function roles()
    {
    	return $this->belongsToMany(Role::class,'permisos_roles','permiso_id');
    }

    public static function findById($id)
    {
    	$permiso = Permiso::where('id','=',$id)->first();
    	return $permiso;
    }

    
}
