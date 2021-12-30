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
                        {{$course -> title}}
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
                            {{$course -> title}}
                        </h1>
                    </div>
                    <div class="course-item__content">
                        <figure class="course-item__img">
                            <img src="{{$course -> image}}" >
                        </figure>
                        <div class="course-item__main">
                            <p class="course-item__descr">
                                {{$course -> description}}
                            </p>
                            <ul class="course-item-lessons">
                                @foreach($course -> lessons as $lesson)
                                    <li class="course-item-lessons__item">
                                        <a href="{{route('lesson.show',[ $course -> edu_type -> slug, $course->slug, $lesson -> slug])}}" class="course-item-lessons__link">
                                            {{$lesson -> title}}
                                        </a>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="course-item__right course-item__right--text-right">
                            <div class="course-item__price">
                                {{$course ->price}} ₽
                            </div>
                            <div class="course-item__actions">
                                <a href="" class="course-item__btn btn">Купить</a>
                            </div>

                        </div>
                    </div>
                    <div class="course-item__footer">
                        <div class="course-item__author">
                            <label class="course-item__author-label">
                                Автор:
                            </label>
                            <span class="course-item__author-value">
                                    {{$course -> author -> name}}
                                {{$course -> author -> surname}}
                                </span>
                            <svg class="course-item__author-icon">
                                <use xlink:href="{{URL::asset('assets/site/images/sprites.svg?ver=12#sprite-question-icon')}}"></use>
                            </svg>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
