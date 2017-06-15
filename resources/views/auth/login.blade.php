@extends('frontend.template')


@section('title')
    {{ $title }}
@stop

@section('header')
    {{ $title }}
@stop

@section('body')
    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}

        @if (Session::has('MESSAGE'))
            <span style="color:red;">{{ Session::get('MESSAGE') }}</span>
        @endif

        <div>
            帳號
            <input type="name" name="name" value="{{ old('name') }}">
        </div>

        <div>
            密碼
            <input type="password" name="password" id="password">
        </div>

        <div>
            <button type="submit">登入</button>
        </div>


    </form>
@stop
