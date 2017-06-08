
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

    <div>{!! link_to('/auth/register', '註冊新帳號') !!}</div>
    <div>{!! link_to('password/forgot_password', '忘記密碼') !!}</div>
</form>