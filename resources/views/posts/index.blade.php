@extends('layouts.app')

@section('content')
    <a href="/posts/create">create new post</a>
            @if(count($posts) > 0)
            @foreach($posts as $post)
                <div class="will">
                <div class="row" >

            <div class="col-md-4 col-sm-4">

                <img src="/images/{{$post->imagePath ?? 'image_1534631547.jpg'}}" alt="image" style="width: 300px;height: 300px">
            </div>
            <div class="col-md-8">
                <h3><a href="/posts/{{$post->title}}">{{$post->title}}</a></h3>
                <small>Written at {{$post->created_at }} by {{$post->admin->first_name}}</small>

            </div>
        </div>
                </div>
                <br>
            @endforeach
    @else
    <div class="jumbotron">
        there are no posts yet
    </div>
    @endif


@endsection