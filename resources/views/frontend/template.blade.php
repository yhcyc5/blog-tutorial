<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>

    <div>
    {!! link_to(route('home'), 'Hello Blog') !!}，
    @if (Auth::check())
        {!! link_to(route('blog',['id' => Auth::user()->id]), Auth::user()->name) !!} 已登入，
        <button>{!! link_to(route('logout'), '登出') !!}</button>
        <button>{!! link_to(route('reset-password'), '更改密碼') !!}</button>

    @else
        {!! link_to(route('register'), '註冊') !!}，
        {!! link_to(route('login'), '帳號登入') !!}，
        {!! link_to(route('login-facebook'), 'facebook登入') !!}，
        <button>{!! link_to(route('forgot-password'), '忘記密碼') !!}</button>

    @endif
    </div>
    <h1>@yield('header')</h1>

    @yield('body')
</body>
</html>