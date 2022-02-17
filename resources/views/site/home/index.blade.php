@extends('site.base.base')
@section('content')
    <home-slider :slides="{{json_encode($slides)}}"></home-slider>
    <home-banners :banners="{{json_encode($banners)}}"></home-banners>
@endsection
