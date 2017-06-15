@extends('frontend.template')


@section('title')
    {{ $title }}
@stop

@section('header')
    {{ $title }}
@stop

@section('body')

    @if (isset($posts))
        <ol>
            @foreach ($posts as $post)
                <li>{!! link_to('blog/'.$post->id, $post->title) !!}</li>
            @endforeach
        </ol>
    @endif
@stop