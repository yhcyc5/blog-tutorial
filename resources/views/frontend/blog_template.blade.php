@extends('frontend.template')


@section('title')
    {{ $blog->name }} 's Blog
@stop

@section('header')

@stop

@section('body')
    @yield('body')
@stop