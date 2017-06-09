
    {!!Form::open(['url'=>'blog', 'method'=>'post'])!!}
    {!!Form::label('title', '標題')!!}<br>
    {!!Form::text('title')!!}<br>
    {!!Form::label('content', '內容')!!}<br>
    {!!Form::textarea('content')!!}<br>
    {!!Form::submit('發表文章')!!}
    {!!Form::close()!!}
    <button>{!! link_to(URL::previous(), '回上一頁') !!}</button>