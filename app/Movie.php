<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];


    public function genres(){

        return $this->belongsToMany(Genre::class,'genre_movie','movie_id','genre_id');
    }
}
