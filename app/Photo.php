<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $primaryKey = 'photo_id';

    public function user()
    {
        return $this->belongsTo('App\User' , 'photo_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Like' , 'photo_id');
    }
}
