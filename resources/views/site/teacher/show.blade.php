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
                        <a href="{{route('teacher.index')}}" class="breadcrumb__link">
                            Преподаватели
                        </a>
                    </li>
                    <li class="breadcrumb__item">
                        {{$teacher -> name}} {{$teacher -> surname}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row teacher-page">
            <div class="col-lg-3">
                <filter-sidebar :filter-start="{{json_encode($filter)}}"></filter-sidebar>
            </div>
            <div class="col-lg-9">
                <section class="teacher-page__description-wrap">
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
            </div>
        </div>
    </div>
@endsection
