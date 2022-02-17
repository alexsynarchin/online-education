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
                Блог
            </li>
        </ul>
        <h1 class="page-title">
            Блог
        </h1>
        <div class="row">
            @foreach($articles as $article)
            <div class="col-md-4 blog-item__wrap">
                <a href="{{route('blog.show', $article->slug)}}" class="blog-item">
                    <figure class="blog-item__preview">
                        <img src="{{$article->image}}">
                    </figure>
                    <section class="blog-item__content">
                        <h3 class="blog-item__title">
                            {{$article->title}}
                        </h3>
                        <p>
                            {{$article->description}}
                        </p>
                    </section>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection
