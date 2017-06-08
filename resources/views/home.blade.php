<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    @if (Auth::check())
        {!! Auth::user()->name !!} 已登入，{!! link_to('auth/logout', '登出') !!}
        {!! link_to('password/reset_password', '更改密碼') !!}
    @endif
    <div>{!! link_to('post/create', '新增文章') !!}</div>
    @if (isset($posts))
        <ol>
            @foreach ($posts as $post)
                <li>{!! link_to('post/'.$post->id, $post->title) !!}
                    ({!! link_to('post/'.$post->id.'/edit', '編輯') !!})</li>
            @endforeach
        </ol>
    @endif
</body>
</html>