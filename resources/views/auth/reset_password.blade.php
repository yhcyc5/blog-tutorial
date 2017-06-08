
<form method="POST" action="/password/reset_password">
    {!! csrf_field() !!}

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