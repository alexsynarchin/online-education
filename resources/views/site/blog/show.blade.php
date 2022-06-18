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
        <section class="article">
            <h1 class="page-title">
                {{$page->title}}
            </h1>
            <div class="article__content">
                {!! $page->text !!}
            </div>
        </section>
    </div>
@endsection
