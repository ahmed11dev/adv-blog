@extends('layouts.app')

@section('content')

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form action="{{ route('register') }}" method="post">
                        {{csrf_field()}}
                        <!-- email ------->
                        <div class="form-group">
                            <label for="email">email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="text" name="email"  value="{{old('email')}}" required>
                            </div>
                        </div>
                            <!-- username ------->
                            <div class="form-group">
                                <label for="username">username</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="username"  value="{{old('username')}}" required>
                                </div>
                            </div>
                            <!-- password ------->
                            <div class="form-group">
                                <label for="password">password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password"  value="{{old('password')}}" required>
                                </div>
                            </div>
                            <!-- password_confirmation------->
                            <div class="form-group">
                                <label for="password_confirmation">password confirmation</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password_confirmation"  required>
                                </div>
                            </div>
                            <!-- first name ------->
                            <div class="form-group">
                                <label for="first_name">first name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                                    <input type="text" name="first_name"  value="{{old('first_name')}}" required>
                                </div>
                            </div>
                            <!-- last name ------->
                            <div class="form-group">
                                <label for="last_name">last name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                                    <input type="text" name="last_name"  value="{{old('last_name')}}" required>
                                </div>
                            </div>
                            <!-- security question ------->
                            <div class="form-group">
                                <label for="security_question">security question</label>
                                <select class="form-control" name="security_question">
                                    <option selected disabled>select question plese</option>
                                    <option value="where_are_you_from">where are you from</option>
                                    <option value="how_are_you">how are you</option>
                                </select>

                            </div>
                            <!-- security answer ------->
                            <div class="form-group">
                                <label for="security_answer">security answer</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-address-book"></i></span>
                                    <input type="text" name="security_answer" required>
                                </div>
                            </div>
                            <!-- dob ------->
                            <div class="form-group">
                                <label for="dob">dob</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                    <input type="date" name="dob" value="{{old('username')}}" required>
                                </div>
                            </div>
                            <!-- location ------->
                            <div class="form-group">
                                <label for="location">location</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" name="location"  value="{{old('location')}}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        register
                                    </button>
                                    </div>
                            </div>


                    </form>
                </div>
            </div>
        </div>

@endsection
