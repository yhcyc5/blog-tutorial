<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = ['title', 'content', 'author'];


    public function user()
    {
        return $this->belongsTo('App\User','author');
    }
}
