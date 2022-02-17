@extends('site.base.base')
@section('content')
    <home-slider :slides="{{json_encode($slides)}}"></home-slider>
    <home-banners :banners="{{json_encode($banners)}}"></home-banners>
    <div class="for-whom container">
        <h2 class="for-whom__title">
            Для кого?
        </h2>
        <div class="row">
            @foreach($for_whom as $item)

                @if($loop->index != 2)
                    <div class="col-md-6 for-whom-item__wrap">
                        <section class="for-whom-item">
                            <div class="for-whom-item__content">
                                <h3 class="for-whom-item__title">
                                    {{$item['title']}}
                                </h3>
                                <div class="for-whom-item__text">
                                    {!! $item['text'] !!}
                                </div>
                            </div>
                            <figure class="for-whom-item__img">
                                <img src="{{$item['image']['link']}}">
                            </figure>
                        </section>
                    </div>
                @else
                    <div class="for-whom-item__wrap col-md-12">
                        <section class="for-whom-item">
                            <div class="for-whom-item__content">
                                <h3 class="for-whom-item__title">
                                    {{$item['title']}}
                                </h3>
                                <div class="for-whom-item__text">
                                    {!! $item['text'] !!}
                                </div>
                            </div>
                            <figure class="for-whom-item__img">
                                <img src="{{$item['image']['link']}}">
                            </figure>
                        </section>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="container">
        <div class="row mb-5">
            <div class="mp-price col-md-6">
                <h3 class="mp-block-title">
                    Ценовая политика
                </h3>
                <ul class="mp-price-list">
                    @foreach($price_list as $item)
                        <li class="mp-price-list__item">
                            <section class="mp-price-list__card mp-price-list__card--{{$loop->index + 1}}">
                                <h4 class="mp-price-list__title">
                                    {{$item['title']}}
                                </h4>
                                <span class="mp-price-list__price">
                                    {{$item['price']}}
                                </span>
                            </section>
                            <section class="mp-price-list__text">
                                    {{$item['text']}}
                            </section>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <section class="mp-you-get">
                    <h3 class="mp-block-title">
                        Вы получаете
                    </h3>
                    <ul class="mp-you-get-list">
                        @foreach($you_get as $item)
                            <li class="mp-you-get-list__item">
                                <figure class="mp-you-get-list__image">
                                    <img src="{{$item['image']['link']}}">
                                </figure>
                                <section class="mp-you-get-list__content">
                                    <h3 class="mp-you-get-list__title">
                                        {{$item['title']}}
                                    </h3>
                                    <p class="mp-you-get-list__text">
                                        {{$item['text']}}
                                    </p>
                                </section>
                            </li>
                        @endforeach
                    </ul>
                </section>

            </div>
        </div>
    </div>
@endsection
