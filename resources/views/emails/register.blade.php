<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>註冊會員認證信</title>
</head>


<body>
    <p>Hi {{ $data['name'] }} 您好：
        <br/>
        <br/>
        您好，請點選<a href="{{ route('user-confirm', ['name' => $data->name, 'token' => $data->confirm_token]) }}" style="color: #178fac">這裡</a>啟動您的帳號。
        <br/>
        <br/>
        如果您無法點選以上連結，請直接複製以下網址
        <br/>
    {{route('user-confirm', ['name' => $data->name, 'token' => $data->confirm_token])}}


</body>
