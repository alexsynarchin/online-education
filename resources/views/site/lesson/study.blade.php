@extends('site.base.base')
@section('content')
    <div class="container">
        <div class="row">
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
        <h1 class="page-title">
            {{$lesson -> title}}
        </h1>
        <div class="mb-4">
            {!! $lesson -> content -> text !!}
        </div>
        </div>

@endsection
