@extends('layouts.app')

@section('title')
    Home page
@endsection

@section('content')
    <x-post-list :posts="$posts" />
@endsection
