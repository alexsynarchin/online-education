@extends('site.base.base')
@section('content')
    <div class="container mb-5">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">
                    Главная
                </a>
            </li>
            <li class="breadcrumb__item">
                <a href="/blog" class="breadcrumb__link">
                    Блог
                </a>
            </li>
            <li class="breadcrumb__item">
                {{$page->title}}
            </li>
        </ul>
        <h1 class="page-title">
            {{$page->title}}
        </h1>
        {!! $page->text !!}
    </div>
@endsection
