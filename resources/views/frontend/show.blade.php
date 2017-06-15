@extends('frontend.template')


@section('title')
    {{ $post->title }}
@stop

@section('header')
    {{ $post->title }}
@stop

@section('body')
    @if (isset($post))
        <p>{{ $post->content }}</p>
        <p>{{ $post->created_at }}</p>
        <p>by - {!! link_to(route('blog', ['id' => $post->author]), $author) !!}</p>
    @endif
    <button>{!! link_to(URL::previous(), '回上一頁') !!}</button>
@stop

