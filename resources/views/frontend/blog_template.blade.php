@extends('frontend.template')


@section('title')
    {{ $blog->name }} 's Blog
@stop

@section('header')
    {{ $blog->name }} 's Blog
@stop

@section('body')
    @yield('body')
@stop