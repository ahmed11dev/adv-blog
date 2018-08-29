@extends('layouts.app')
<link href="{{ asset('css/comment.css') }}" rel="stylesheet" />
@section('content')



    <div class="container">
        <div class="col-sm-8">
            <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                    <div class="pull-left image">
                        <img src="{{asset("profile_picture/".$post->admin->profile_picture)}}" class="img-circle avatar" alt="user profile image">
                    </div>
                    <div class="pull-left meta">
                        <div class="title h5">
                            <a href="#"><b>{{$post->admin->first_name}} {{$post->admin->last_name}}</b></a>
                            made a post.
                        </div>
                        <h6 class="text-muted time">{{$post->created_at }}</h6>
                    </div>
                </div>
                <hr>
                <div class="post-description">
            <h2 style="padding-top: 0px;margin-top: 0px">{{$post->title}}</h2>
                    <img src="/images/{{$post->imagePath}}" alt="image" style="width: 400px;height: 500px">
                    <br>
            <p>{{$post->body}}</p>
                   <div >
                       <div class="dropdown">
                           <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">post managing</button>

                           <ul class="dropdown-menu">
                               @if($post->approved === 0)
                                   @if(Sentinel::getUser()->hasAnyAccess('*.approve'))
                                    <li>
                                        <a href="{{route('posts.approve',$post->id)}}" onclick="event.preventDefault();
                                        document.getElementById('approve-form').submit();"> approve this post
                                        </a>
                                        <form id="approve-form" action="{{route('posts.approve',$post->id)}}" method="post" style="display: none;">
                                        {{csrf_field()}}
                                        </form>
                                    </li>
                                   @endif
                               @endif
                                   @if(Sentinel::getUser()->hasAnyAccess('*.delete'))

                                       <li>
                                           <a href="{{route('posts.destroy',$post->title)}}" onclick="event.preventDefault();
                                        document.getElementById('delete-form').submit();"> delete this post
                                           </a>
                                           <form id="delete-form" action="{{route('posts.destroy',$post->title)}}" method="post" style="display: none;">
                                               {{method_field('DELETE')}}
                                               {{csrf_field()}}
                                           </form>
                                       </li>
                                       @endif
                                   @if(Sentinel::getUser()->hasAnyAccess('*.edit'))
                                       <li>
                                           <a href="/posts/{{$post->title}}/edit">edit this posts</a>
                                   @endif

                           </ul>
                       </div>
                   </div>
                </div>

                <div class="post-footer">
                    <form action="{{route('comments.store',$post->title)}}" method="post">
                    {{csrf_field()}}
                        <div class="input-group">
                        <input class="form-control" name="comment" placeholder="Add a comment" type="text" autocomplete="non">
                        <span class="input-group-addon">
                        <a href="#"><i class="far fa-edit"></i></a>
                    </span>
                    </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">
                            <i class="far fa-comments" aria-hidden="true"></i>
                            add comment
                            </button>
                        </div>
                    </form>
                    @foreach($post->comments as $comment)
                    <ul class="comments-list">
                        <li class="comment">
                            <a class="pull-left" href="/profile/{{$comment->user->first_name}}">

                                <img src="{{asset("profile_picture/".$comment->user->profile_picture)}}" class="img-circle avatar" alt="user profile image">
                            </a>
                            <div class="comment-body">
                                <div class="comment-heading">
                                    <h4 class="user">{{$comment->user->first_name}} {{$comment->user->last_name}}</h4>
                                    <h5 class="time">{{$comment->created_at->diffForHumans() }}</h5>
                                </div>

                                @if (\Route::currentRouteName() === 'comments.edit')
                                    @if (request()->route('comment')->id === $comment->id)
                                <form action="{{ route('comments.update', ['comment' => $comment->id , 'post' => $post->title]) }}" method="post">
                                    {{method_field('PUT')}}
                                    {{csrf_field()}}

                                    <input type="text" name="comment" value="{{ $comment->body }}" class="form-control">
                                    <hr>
                                    <input type="submit" class="form-control" value="Edit Comment">
                                </form>
                                    @else
                                    <h4> {{ $comment->body }}</h4>

                                    @endif
                                @else
                                    <h4> {{ $comment->body }}</h4>
                                @endif
                                <p><a href="/comments/{{$comment->id}}/{{$post->title}}">edit</a>
                                    |
                                    <a href="{{ route('comments.destroy',$comment->id) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('comment-destroy-form').submit();">
                                        Delete
                                    </a>
                                <form id="comment-destroy-form" action="{{ route('comments.destroy',$comment->id) }}" method="POST" style="display: none;">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}

                                </form>
                                </p>
                            </div>
                            <ul class="comments-list">
                                <li class="comment">
                                    <form action="{{ route('replies.store',['post' => $post->title,'comment' => $comment->id]) }}" method="POST">

                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input type="text" name="comment" placeholder="Add a reply" class="form-control" style="height: 50px;">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary form-control">
                                                <i class="fa fa-reply" aria-hidden="true"></i>
                                                Add Reply
                                            </button>
                                        </div>

                                    </form>
                                    @if ($comment->replies->count())
                                        @foreach ($comment->replies as $reply)
                                            <a class="pull-left" href="/profile/{{$comment->user->username}}">
                                                <img src="{{asset("profile_picture/".$comment->user->profile_picture)}}" class="img-circle avatar" alt="User Profile Image">
                                            </a>
                                            <div class="comment-body">
                                                <div class="comment-heading">
                                                    <h4 class="user">{{$reply->user->first_name . ' '. $reply->user->last_name}}</h4>
                                                    <h5 class="time">{{ $reply->created_at->diffForHumans() }}</h5>

                                                </div>
                                                @if (\Route::currentRouteName() == 'replies.edit')
                                                    @if (request()->route('reply')->id === $reply->id)
                                                        <form action="{{ route('replies.update', ['reply' => $reply->id ,'comment' => $comment->id , 'post' => $post->title]) }}" method="POST">
                                                            {{ method_field('PUT') }}
                                                            {{csrf_field()}}
                                                            <input type="text" name="comment" value="{{ $reply->body }}" class="form-control">
                                                            <hr>
                                                            <input type="submit" class="form-control" value="Edit Reply">
                                                        </form>
                                                    @else
                                                        <h4> {{ $reply->body }}</h4>
                                                    @endif
                                                @else
                                                    <h4> {{ $reply->body }}</h4>
                                                @endif
                                                <small>
                                                    <p>
                                                        <a href="/replies/{{$reply->id}}/{{ $post->title}}"> Edit </a>
                                                        |
                                                        <a href="{{ route('replies.destroy',$reply->id) }}"
                                                           onclick="event.preventDefault();
                                                     document.getElementById('reply-destroy-form').submit();">
                                                            Delete
                                                        </a>

                                                    <form id="reply-destroy-form" action="{{ route('replies.destroy',$reply->id) }}" method="POST" style="display: none;">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}

                                                    </form>

                                                    </p>
                                                </small>
                                            </div>
                                            @endforeach
                                    @endif

                                </li>

                            </ul>
                        </li>
                    </ul>
               @endforeach
                </div>
            </div>
        </div>
    </div>
<!------------- -->
    <hr>
    <a href="/posts">back to posts</a>
    <br>
    @if(Sentinel::getUser()->hasAnyAccess(['admin.*','moderator.*']))

        @if(Sentinel::getUser()->hasAccess('admin.delete'))
            <form action="{{route('posts.destroy',$post->title) }}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit"  value="DELETE">
            </form>
        @endif
        @if(Sentinel::getUser()->hasAccess('admin.approve'))
            <form action="{{route('posts.approve',$post->id) }}" method="post">
                {{csrf_field()}}
                <input type="submit"  value="approve">
            </form>
        @endif
    @endif
    @endsection