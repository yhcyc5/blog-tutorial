<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>
<div>{!! link_to('post/create', '新增') !!}</div>
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