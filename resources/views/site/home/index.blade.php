@extends('site.base.base')
@section('content')
    <home-slider :slides="{{json_encode($slides)}}"></home-slider>
    <home-banners :banners="{{json_encode($banners)}}"></home-banners>
    <home-how-to-use-site></home-how-to-use-site>
    <home-banner></home-banner>
    <home-plus></home-plus>
    <home-study-items></home-study-items>
@endsection
