@extends('layouts.app')

@section('content')
    <form action="{{route('posts.update',$post->title)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
        <!--   ------------ title -----------   -->
        <div class="form-group">
            <label for="title" >title</label>
            <input type="text" class="form-control" name="title" placeholder="title of post" value="{{$post->title}}">
        </div>
        <!--   ------------ body -----------   -->
        <div class="form-group">
            <label for="body" >body</label>
            <input type="text" class="form-control" name="body" value="{{$post->body}}">
        </div>

        <!--   ------------ image -----------   -->
        <div class="form-group">
            <label for="imagePath" >upload your image</label>
            <input type="file" class="form-control" name="imagePath" >
        </div>

            <!--   ------------ tags -----------   -->
        <div class="form-group">
            <label for="tags"> Current Tags</label>

            <input type="text" class="form-control" name="tags" value="{{ implode(' ',$post->tags->pluck('name')->toArray()) }}" placeholder="Post Title">
        </div>


        <div class="form-group">
            <input type="submit" class="form-control"  value="edit this post">
        </div>

    </form>
@endsection