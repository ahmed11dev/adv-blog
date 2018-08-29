@extends('layouts.app')

@section('content')

    @if(Sentinel::getUser()->id === $user->id)

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">profile form</div>

            <div class="panel-body">
                <form action="{{ route('profile') }}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <!-- email ------->
                    <div class="form-group">
                        <label for="email">email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" name="email"  value="{{old('email')}}" >
                        </div>
                    </div>

                    <!-- password ------->
                    <div class="form-group">
                        <label for="password">password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password"  value="{{old('password')}}" >
                        </div>
                    </div>

                    <!-- first name ------->
                    <div class="form-group">
                        <label for="first_name">first name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                            <input type="text" name="first_name"  value="{{old('first_name')}}" >
                        </div>
                    </div>
                    <!-- last name ------->
                    <div class="form-group">
                        <label for="last_name">last name</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                            <input type="text" name="last_name"  value="{{old('last_name')}}" >
                        </div>
                    </div>


                    <!-- location ------->
                    <div class="form-group">
                        <label for="location">location</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="location" placeholder="your location" value="{{old('location')}}" required>
                        </div>
                    </div>
                    <!-- profile image ------->
                    <div class="form-group">
                        <label for="update_profile">update profile picture</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-upload"></i></span>
                            <input type="file" name="profile_picture" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                update profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
        <ul class="list-group">
            <li class="list-group-item">name : {{$user->username}}</li>
            <li class="list-group-item">first name : {{$user->first_name}}</li>
            <li class="list-group-item">last name : {{$user->last_name}}</li>
            <li class="list-group-item">live in : {{$user->location}}</li>
        </ul>
    @endif
@endsection
