@extends('site.base.base')
@section('content')
    <div class="container">
        <div class="row">
            @if(!$lesson->user_buy)
            <div class="col-lg-3"></div>
            @endif
            <div class="@if($lesson->user_buy)col-12 @else col-lg-9 @endif">
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
            @if(!$lesson->user_buy)
            <div class="col-lg-3">
                <filter-sidebar :filter-start="{{json_encode($filter)}}"></filter-sidebar>
            </div>
            @endif
            <div class="  @if($lesson->user_buy)col-12 @else col-lg-9 @endif">
                <section class="course-item course-item-block">
                    <div class="course-item__heading">
                        <h1 class="course-item__title course-item__title--big">
                            {{$lesson -> title}}
                        </h1>
                    </div>
                    <div class="course-item__content">
                        @if($lesson->user_buy)
                            <div>
                                <div class="mb-4">
                                    {!! $lesson -> content -> text !!}
                                </div>
                                <div class="d-flex mb-4">
                                    @if($lesson->tests()->exists())
                                    <lesson-test :lesson_title="'{{json_encode($lesson->title)}}'" :id="{{json_encode($lesson->id)}}"></lesson-test>
                                    @endif
                                    <send-msg :lesson_id="{{json_encode($lesson->id)}}"></send-msg>
                                </div>
                            </div>

                        @else
                            <div class="course-item__main">
                                <div class="course-item__descr course-item__descr--lesson">
                                    {!! $lesson -> content -> text !!}
                                </div>
                                @if(!$lesson->user_buy)
                                    <div class="course-item__buy">
                                        Для просмотра урока его необходимо <buy-btn :type="'link'" :buying_type="'lesson'"
                                                                                    :buying_id="{{$lesson->id}}"
                                                                                    v-if="{{json_encode(!$lesson->user_buy)}}"></buy-btn>
                                    </div>
                                @endif
                            </div>
                            <div class="course-item__right course-item__right--text-right">
                                @if(!$lesson->user_buy)
                                    <div class="course-item__price">
                                        {{$lesson ->price_user}} ₽
                                    </div>

                                    <div class="course-item__actions">
                                        <buy-btn :buying_type="'lesson'"  :buying_id="{{$lesson->id}}" v-if="{{json_encode(!$lesson->user_buy)}}"></buy-btn>
                                    </div>
                                @else
                                    <a href="{{route('lesson.study',[ $course -> edu_type -> slug, $course->slug, $lesson -> slug])}}"
                                       class="course-item__btn btn">Перейти</a>
                                @endif
                            </div>
                        @endif

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
