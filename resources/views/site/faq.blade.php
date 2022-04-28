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
                    Поддержка
                </li>
            </ul>
            <h1 class="page-title">
                Страница поддержки
            </h1>
            <faq></faq>
        </div>
@endsection
