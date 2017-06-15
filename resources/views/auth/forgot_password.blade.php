@extends('frontend.template')


@section('title')
    {{ $title }}
@stop

@section('header')
    {{ $title }}
@stop

@section('body')
<form method="POST" action="/password/forgot_password">
    {!! csrf_field() !!}

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    @if (Session::has('MESSAGE'))
        <span style="color:red;">{{ Session::get('MESSAGE') }}</span>
    @endif
    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        <button type="submit">
            傳送重置密碼連結
        </button>
    </div>
</form>
@stop
