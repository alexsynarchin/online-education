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
                Контакты
            </li>
        </ul>
        <h1 class="page-title">
            Контакты
        </h1>
        <div class="mb-3">
            <label>Профиль организации в яндекс: </label>
            <a href="https://yandex.ru/profile/146316824544">https://yandex.ru/profile/146316824544</a>
        </div>
        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A3a497ae5a132b2f3ff9997405e3f1115582e81c0783182f189793f4e8944293f&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
    </div>
@endsection
