<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1758704814421119',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

    <div>
    {!! link_to(route('home'), 'Hello Blog') !!}，
    @if (Auth::check())
        {!! link_to(route('blog',['id' => Auth::user()->id]), Auth::user()->name) !!} 已登入，
            <button>{!! link_to('auth/logout', '登出') !!}</button>
                <button>{!! link_to('password/reset_password', '更改密碼') !!}</button>
        @yield('header')
    @else
        {!! link_to('/auth/register', '註冊') !!}，
        {!! link_to('/auth/login', '帳號登入') !!}，
            {!! link_to('login/facebook', 'facebook登入') !!}

    @endif
    </div>
    <h1>@yield('title')</h1>



    @yield('body')
</body>
</html>