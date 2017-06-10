
    @if (isset($post))
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>
        <p>{{ $post->created_at }}</p>
        <p>by - {!! link_to(route('blog', ['id' => $post->creator_id]), $creator) !!}</p>
    @endif
    <button>{!! link_to(URL::previous(), '回上一頁') !!}</button>
