<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable =['type_id','user_id','body','is_readed'];

    public function type()
    {
    	return $this->belongsTo(TypeNotification::class,'type_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id');
    }
}
