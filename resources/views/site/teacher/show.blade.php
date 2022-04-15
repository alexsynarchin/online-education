@extends('site.base.base')
@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">
                    Главная
                </a>
            </li>
            <li class="breadcrumb__item">
                <a href="{{route('teacher.index')}}" class="breadcrumb__link">
                    Преподаватели
                </a>
            </li>
            <li class="breadcrumb__item">
                {{$teacher -> name}} {{$teacher -> surname}}
            </li>
        </ul>
        <div class="teacher-page">
            <section class="teacher-page__description-wrap course-item-block">
                <figure class="teacher-page__avatar">
                    <img src="{{$teacher -> avatar}}">
                </figure>
                <div class="teacher-page__description">
                    <h1 class="teacher-page__title">
                        {{$teacher -> name}} {{$teacher -> surname}}
                    </h1>
                    <ul class="teacher-page-descr-list">
                        <li class="teacher-page-descr-list__item">
                            <label class="teacher-page-descr-list__label">
                                Предметы:
                            </label>
                            @foreach($teacher -> subjects as $subject)
                                @if ($loop->last)
                                    {{$subject}}
                                @else
                                    {{$subject}},
                                @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
            </section>
            @if(count($teacher -> teacherCourses) > 0)
                <h3 class="course-item-block__title">
                    Список курсов преподавателя:
                </h3>
            @endif
            @if(count($teacher -> teacherCourses) > 0)
                <teacher-course-list :courses="{{json_encode($teacher -> teacherCourses)}}"></teacher-course-list>
            @endif

        </div>
    </div>
@endsection
