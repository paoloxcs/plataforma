<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeNotification extends Model
{
    protected $table ='types_notification';
    protected $fillable =['name'];

    public function notifications()
    {
    	return $this->hasMany(Notification::class);
    }
}
