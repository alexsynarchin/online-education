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
        Поиск преподавателя
    </li>
</ul>
<h1 class="page-title">
    Поиск преподавателя
</h1>
<search-teachers></search-teachers>
</div>

@endsection
