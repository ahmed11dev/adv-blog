@extends('layouts.app')

@section('content')

    <p>welcome in admin panal</p>
    <hr>
    <a href="/change-password">change your password</a>
    <br>
    <a href="/posts">show all posts</a>
    <hr>
    <p>admin roles</p>
    @foreach($user->roles->first()->permissions as $permisson =>$value)
    <span>{{$permisson }} - </span>
    @endforeach
    <hr>
<p style="color: #761c19;font-size: 2em">user roles</p>
    @foreach($user->permissions as $permisson =>$value)
        <p>{{$permisson }}</p>
    @endforeach
@endsection