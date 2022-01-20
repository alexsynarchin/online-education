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
                        <a href="{{route('catalog', ['edu_slug' => $course -> edu_type -> slug,
                                                      'subjects' => [(int) $course -> subject -> id]])}}" class="breadcrumb__link">
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
                <section class="course-item course-item-block">
                    <div class="course-item__heading">
                        <h1 class="course-item__title course-item__title--big">
                            {{$lesson -> title}}
                        </h1>
                    </div>
                    <div class="course-item__content">
                        <div class="course-item__main">
                            <div class="course-item__descr course-item__descr--lesson">
                                {!! $lesson -> content -> text !!}
                            </div>
                            <div class="course-item__buy">
                                Для просмотра урока его необходимо <a href="" class="course-item__buy-link">купить</a>
                            </div>
                        </div>
                        <div class="course-item__right course-item__right--text-right">
                            <div class="course-item__price">
                                {{$lesson ->price_user}} ₽
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
                @if(count($other_lessons) > 0)
                <section class="course-item-block">
                    <h3 class="course-item-block__title">
                        Другие уроки курса:
                    </h3>
                    <ul class="other-lessons course-item-lessons">
                        @foreach($other_lessons as $lesson)
                            <li class="course-item-lessons__item">
                                <a class="course-item-lessons__link course-item-lessons__link--flex" href="{{route('lesson.show', [$course -> edu_type -> slug, $course -> slug, $lesson -> slug])}}">
                                    <span class="course-item-lessons__title">
                                        {{$lesson->title}}
                                    </span>
                                    <span class="course-item-lessons__price">
                                        {{$lesson -> price_user}} ₽
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
                @endif
            </div>
        </div>
    </div>
@endsection
