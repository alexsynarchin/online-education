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
                Поиск
            </li>
        </ul>
        <h1 class="page-title">
            Поиск
        </h1>
        <div class="col-lg-9">
            @if(count($courses) > 0)
                <h3 class="search__title">
                    Результаты по названию курса:
                </h3>
                @foreach($courses as $course)
                    @include('site.course.item', ['course' => $course])
                @endforeach
            @endif
            @if(count($themes) > 0)
                <h3 class="search__title">
                    Результаты по названию темы:
                </h3>
                @foreach($themes as $course)
                    @include('site.course.item', ['course' => $course])
                @endforeach
            @endif
            @if(count($courses) === 0 && count($themes) === 0)
                    <el-alert
                        title="По вашему запросу ничего не найдено"
                        :closable="false"
                        type="warning"
                        class="mb-4"
                        show-icon>
                    </el-alert>
            @endif
        </div>
    </div>

@endsection
