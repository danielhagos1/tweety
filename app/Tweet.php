<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
Protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}