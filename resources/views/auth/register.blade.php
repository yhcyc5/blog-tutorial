
<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

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
        <button type="submit">註冊</button>
    </div>
    <div>
        {!! link_to('/auth/login', '去登入頁面') !!}
    </div>
</form>