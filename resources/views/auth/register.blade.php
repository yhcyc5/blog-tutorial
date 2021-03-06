@extends('frontend.template')


@section('title')
    {{ $title }}
@stop

@section('header')
    {{ $title }}
@stop

@section('body')
    <form method="POST" action="/auth/register">
        {!! csrf_field() !!}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            帳號
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            信箱
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            密碼
            <input type="password" name="password">
        </div>

        <div>
            確認密碼
            <input type="password" name="password_verify">
        </div>

        <div>
            <button type="submit">註冊</button>
        </div>
    </form>
@stop
