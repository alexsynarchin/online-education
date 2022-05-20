@if(isset($page->blocks['youtube_link']) && $page->blocks['youtube_link'] )
    <iframe width="100%"  class="about-page__video"
            src="{{$page->blocks['youtube_link']}}">
    </iframe>
    <div class="row mb-4">
        <div class="col-md-7 about-page__left">
            <h1 class="about-page__title">
                {{$page->name}}
            </h1>
            <div class="about-page__content">
                {!! $page->text !!}
            </div>

            @if(isset($page->blocks['about_list']) && $page->blocks['about_list'] )
                <ul class="about-list">
                    @foreach($page->blocks['about_list'] as $item)
                        <li class="about-list__item">
                            <figure class="about-list__image">
                                <img src="{{$item['image']['link']}}">
                            </figure>
                            <section class="about-list__content">
                                <h3 class="about-list__title">
                                    {{$item['title']}}
                                </h3>
                                <p class="about-list__text">
                                    {{$item['text']}}
                                </p>
                            </section>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-md-5">
            <figure class="about-page__image">
                <img src="{{$page->blocks['image']['link']}}">
            </figure>
        </div>
    </div>
@endif

