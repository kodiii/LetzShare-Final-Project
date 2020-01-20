<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $primaryKey = 'like_id';

    public function user()
    {
        return $this->belongsTo('App\User' , 'like_id');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo' , 'like_id');
    }

}
