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
                        <a href="{{route('catalog', $course -> edu_type -> slug)}}" class="breadcrumb__link">
                            {{$course -> edu_type -> title}}
                        </a>
                    </li>
                    <li class="breadcrumb__item">
                        <a href="{{route('catalog', $course -> edu_type -> slug) . '?subjects=' . $course -> subject -> id}}" class="breadcrumb__link">
                            {{$course -> subject -> title}}
                        </a>
                    </li>
                    <li class="breadcrumb__item">
                        <a href="{{route('catalog.show', [$course -> edu_type -> slug, $course -> slug])}}" class="breadcrumb__link">
                            {{$course ->  title}}
                        </a>
                    </li>
                    <li class="breadcrumb__item">
                        {{$lesson->title}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <filter-sidebar :filter-start="{{json_encode($filter)}}"></filter-sidebar>
            </div>
            <div class="col-lg-9">
                <section class="course-item">
                    <div class="course-item__heading">
                        <h1 class="course-item__title course-item__title--big">
                            {{$lesson -> title}}
                        </h1>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
