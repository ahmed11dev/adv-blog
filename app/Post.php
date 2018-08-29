<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    function getRouteKeyName()
    {
        return 'title';
    }

    function admin()
    {
        return $this->belongsTo(admin::class);
    }

    function comments()
    {
        return $this->hasMany(Comment::class);
    }
    function replies()
    {
        return $this->hasMany(Reply::class);
    }
    function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value)->diffForHumans();
    }

}
