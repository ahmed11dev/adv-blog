<?php

namespace App;

use Sentinel;
use Activation;
use Cartalyst\Sentinel\Users\EloquentUser;
//use Illuminate\Database\Eloquent\Model;

class admin extends EloquentUser
{
    protected $table = 'users';

    static function listOnlineUsers()
    {
        $users = static::pluck('id')->all();

        foreach($users as $user)
        {
            if (Activation::completed(static::find($user))){
                $code = Sentinel::findById($user)->persistences->first()->code ?? null;
                if ($code){
                    $user = Sentinel::findByPersistenceCode($code);
                    if ($user){
                        $online_Users[] = $user;
                    }
                }

            }
            continue; // continue if user not activate
        }
       return $online_Users ?? null;
    }

    public static function upgradeUser($id,$permissions)
    {
        $user = Sentinel::findById($id);
        if ($user->hasAccess('admin.*')){
            return false;
        }

        if (is_array($permissions))
        {                            // admin.create true
            foreach ($permissions as $permission => $value){// 3(true) to  create if not exists
                $user->updatePermission($permission,$value,true)->save(); // or ew can use addPermission
            }
            return true;
        }else{                         //  2true to update in same user 3true to  create if not exists
            $user->updatePermission($permissions,true,true)->save();
            return true;
        }
        return false;
    }

    public static function downgradeUser($id,$permissions)
    {
        $user = Sentinel::findById($id);
        if ($user->hasAccess('admin.*')){
            return false;
        }
        if (is_array($permissions))
        {
            foreach ($permissions as $permission => $value){
                $user->updatePermission($permission,false)->save();
            }
            return true;
        }else{
            $user->removePermission($permissions)->save();
            return true;
        }
        return false;

    }

    function posts()
    {
        return $this->hasMany(Post::class);
    }
    function comment()
    {
        return $this->hasMany(Comment::class);
    }
    function replies()
    {
        return $this->hasMany(Reply::class);
    }
    function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public static function approve($id)
    {
        $post = \App\Post::find($id)->whereApproved(0)->first();
        if ($post)
        {
            $post->approved = 1;
            $post->approved_by = Sentinel::getUser()->username;
            $post->save();
            return true;
        }
        return false;
    }

}
