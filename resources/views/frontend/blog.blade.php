@extends('frontend.blog_template')


@section('body')
    @if (Auth::check() && $blogger_name == Auth::user()->name)
        <div>
            <button>{!! link_to('blog/create', '新增文章') !!}</button>
        </div>
    @endif
    @if (isset($posts))
        <ol>
            @foreach ($posts as $post)
                <li>{!! link_to('blog/'.$post->id, $post->title) !!}
                @if (Auth::check() && $blogger_name == Auth::user()->name)
                    <button>
                        {!! link_to('blog/'.$post->id.'/edit', '編輯') !!}
                    </button>
                @endif
                </li>
            @endforeach
        </ol>
    @endif
@stop