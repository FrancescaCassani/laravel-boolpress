<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Mass Assignment
    protected $fillable = [
        'user_id',
        'title',
        'where',
        'body',
        'slug'
    ];


    //Relazione del DB:  POSTS - USERS
    public function user() {
        return $this->belongsTo('App\User');
    }
}
