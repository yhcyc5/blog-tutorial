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
            <button>{!! link_to('auth/logout', '登出') !!}</button>
                <button>{!! link_to('password/reset_password', '更改密碼') !!}</button>
        @yield('header')
    @else
        {!! link_to('/auth/register', '註冊') !!}，
        {!! link_to('/auth/login', '登入') !!}
    @endif
    </div>
    <h1>@yield('title')</h1>



    @yield('body')
</body>
</html>