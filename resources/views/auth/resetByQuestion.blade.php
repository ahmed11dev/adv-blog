@extends('layouts.app')


@section('panel-heading')
        <p class="text-center">{{\Session::get('question')?? 'Reset you password' }}</p>
    @endsection

@section('content')

    @if(session('question'))
    <form action="{{route('reset.security2')}}" method="post">
        {{csrf_field() }}
        <label for="emailsecurity_answer">answer you sec question</label>
        <input type="text" name="security_answer">
        <input type="submit" value="stage 2">
    </form>
    @elseif(session('stage3'))
        <form action="{{route('reset.security3')}}" method="post">
            {{csrf_field() }}
            <label for="password">password</label>
            <input type="password" name="password">
            <input type="submit" value="change password">
        </form>
    @else
        <form action="{{route('reset.security1')}}" method="post">
            {{csrf_field() }}
            <label for="email">email</label>
            <input type="email" name="email">
            <input type="submit" value="next">
        </form>
    @endif
    @endsection