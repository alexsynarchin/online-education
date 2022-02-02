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
                        <a href="{{route('catalog', [
                                                        'edu_slug' => $course -> edu_type -> slug,
                                                      'direction' => \App\Models\Category\CategoryType::find($course -> direction_id)['slug'],
                                                      'subjects' => [(int) $course -> subject -> id,

                                                      ]])}}" class="breadcrumb__link">
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

                <section class="course-item course-item-block">
                    <div class="course-item__heading">
                        <h1 class="course-item__title course-item__title--big">
                            {{$course -> title}}
                        </h1>
                        @if($course->rating > 0)
                        <course-rating
                        :count="1"
                        :rating="{{json_encode($course->rating)}}"
                        ></course-rating>
                        @endif
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
                                        <a href="{{route('lesson.show',[ $course -> edu_type -> slug, $course->slug, $lesson -> slug])}}"
                                           class="course-item-lessons__link">
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
                                <buy-btn :buying_id="{{$course->id}}" v-if="{{json_encode(!$course->user_buy)}}"></buy-btn>
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
                @if(count($other_courses) > 0)
                <section class="course-item-block">
                    <h3 class="course-item-block__title">
                        Другие курсы преподавателя:
                    </h3>
                    <ul class="other-courses">
                        @foreach($other_courses as $item)
                            <li class="other-courses__item">
                                <a href="{{route('catalog.show', [$item -> edu_type -> slug,$item -> slug])}}" class="other-courses__link">
                                    <h4 class="other-courses__title">
                                        {{$item -> title}}
                                    </h4>
                                    <div class="other-courses__link-right">
                                        <span class="other-courses__price">
                                            {{$item -> price}} ₽
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
                @endif
                <comments
                    :show_comment="{{json_encode($show_comment)}}"
                    :course_id="{{json_encode($course->id)}}">
                </comments>
            </div>
        </div>
    </div>
@endsection
