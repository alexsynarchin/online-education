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
                        Поиск преподавателя
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <filter-sidebar :filter-start="{{json_encode($filter)}}"></filter-sidebar>
            </div>
            <div class="col-lg-9">
                <h1 class="page-title">
                    Поиск преподавателя
                </h1>
                <search-teachers></search-teachers>
            </div>
        </div>
    </div>
@endsection
