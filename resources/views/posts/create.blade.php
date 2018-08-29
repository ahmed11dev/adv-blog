@extends('layouts.app')

@section('content')
    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="title" >title</label>
            <input type="text" class="form-control" name="title" placeholder="title of post" value="{{old('title')}}">
        </div>

        <div class="form-group">
            <label for="body" >body</label>
            <input type="text" class="form-control" name="body" value="{{old('title')}}">
        </div>

        <div class="form-group">
            <label for="imagePath" >upload your image</label>
            <input type="file"  name="imagePath" >
        </div>

        <div class="form-group">
            <label for="tags"> Tags</label>
            <input type="text" class="form-control" name="tags" value="{{ old('tags') }}" placeholder="Post Tags">
        </div>


        <div class="form-group">
            <input type="submit" class="form-control"  value="create">
        </div>

    </form>
    <a href="/posts">back to posts</a>
    @endsection