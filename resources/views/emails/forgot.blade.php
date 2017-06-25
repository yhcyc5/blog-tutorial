<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>取得新密碼</title>
</head>

<body>
<p>Hi {{ $user->present()->getUserName() }} 您好：
    <br/>
    <br/>
    您好，請使用新密碼：{{ $user->password }}
    登入網址：
    <a href="{{ route('login') }}" style="color: #178fac">這裡</a>
    登入後可自行更改密碼。
    <br/>
</body>