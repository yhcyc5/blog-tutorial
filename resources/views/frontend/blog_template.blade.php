@extends('frontend.template')


@section('title')
    {{ $blogger_name }} 's Blog
@stop

@section('header')
    {{ $blogger_name }} 's Blog
@stop

@section('body')
    @yield('body')
@stop