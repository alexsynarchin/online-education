@extends('site.base.base')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">

            </div>
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
                <h1 class="page-title">
                    {{$title}}
                </h1>
                @foreach($courses as $course)
                    <section class="course-item">
                        <div class="course-item__heading">
                            <h4 class="course-item__title">
                                {{$course -> title}}
                            </h4>
                        </div>
                        <div class="course-item__content">
                            <figure class="course-item__img">
                                <img src="{{$course -> image}}" >
                            </figure>
                            <div class="course-item__main">
                                <p class="course-item__descr">
                                    {{$course -> description}}
                                </p>
                            </div>
                            <div class="course-item__right">
                                <div class="course-item__price">
                                    {{$course ->price}} ₽
                                </div>
                                <div class="course-item__actions">

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
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>
@endsection
