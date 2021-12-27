@extends('site.base.base')
@section('content')
    Главная страница
    {{Auth::user()}}
@endsection
