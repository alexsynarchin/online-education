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

@endsection
