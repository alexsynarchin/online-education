@extends('site.base.base')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-9">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item">
                        <a href="/" class="breadcrumb__link">
                            Главная
                        </a>
                    </li>
                    <li class="breadcrumb__item">
                        {{$title}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('site.base._partials.sidebar')
            </div>
            <div class="col-lg-9">
                <h1 class="page-title">
                    {{$title}}
                </h1>
                <course-list></course-list>
            </div>
        </div>
    </div>
@endsection
