@extends('frontend.template')


@section('title')
    {{ $title }}
@stop

@section('header')
    {{ $title }}
@stop

@section('body')
    {!! Form::open(['url'=>'blog/'.$post->id, 'method'=>'put']) !!}
    {!! Form::label('title', '標題') !!}<br>
    {!! Form::text('title', $post->title) !!}<br>
    {!! Form::label('content', '內容') !!}<br>
    {!! Form::textarea('content', $post->content) !!}<br>
    {!! Form::submit('儲存') !!}
    {!! Form::close() !!}

    {!! Form::open(['url'=>'blog/'.$post->id, 'method'=>'delete']) !!}
    <button type="submit">刪除</button>
    {!! Form::close() !!}

    <button>{!! link_to(URL::previous(), '回上一頁') !!}</button>
@stop

