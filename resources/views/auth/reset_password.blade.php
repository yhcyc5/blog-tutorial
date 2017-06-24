@extends('frontend.template')


@section('title')
    {{ $title }}
@stop

@section('header')
    {{ $title }}
@stop

@section('body')
    <form method="POST" action="/auth/reset_password">
        {!! csrf_field() !!}

        @if (Session::has('MESSAGE'))
            <span style="color:red;">{{ Session::get('MESSAGE') }}</span>
        @endif

        <div>
            信箱
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div>
            新密碼
            <input type="password" name="new_password">
        </div>

        <div>
            <button type="submit">
                更改密碼
            </button>
        </div>
    </form>
@stop
