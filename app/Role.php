<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name','grupo'];

    public $timestamps = false;

    public function users()
    {
    	return $this->hasMany(User::class);
    }
    public function permisos()
    {
    	return $this->belongsToMany(Permiso::class,'permisos_roles','role_id');
    }
    public function hasPermisoTo($perm_id)
    {
        $permiso = app(Permiso::class)->findById($perm_id);

        return $this->permisos->contains('id',$permiso->id);
    }
}
