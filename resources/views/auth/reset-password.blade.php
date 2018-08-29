@extends('layouts.app')

@section('content')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Reset new password</div>

            <div class="panel-body">
                <form action="{{ route('password-reset') }}" method="post">
                {{csrf_field()}}

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
                            <input type="password" name="password_confirmation"   required>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                submit new password
                            </button>

                </form>
            </div>
        </div>
    </div>

@endsection
