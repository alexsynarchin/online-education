<h1 class="instruction-page__title">
    {{$page->name}}
</h1>
<div class="instruction-page__content">
    {!! $page->text !!}
</div>

@if(isset($page->blocks['instr_blocks']) && $page->blocks['instr_blocks'] )
    @foreach($page->blocks['instr_blocks'] as $item)
        <section class="instruction-block @if(isset($item['border']) &&  $item['border'] == false) instruction-block--none-border @endif"  >
            @if($item['title'])
            <h3 class="instruction-block__title">
                {{$item['title']}}
            </h3>
            @endif
            @if($item['text'])
                <div class="instruction-block__text">
                    {!! $item['text'] !!}
                </div>
            @endif
            @if(count($item['images']))
                <div class="instruction-block__gal">
                    @foreach($item['images'] as $image)

                        <figure class="instruction-block__gal-image @if(count($item['images']) > 0) instruction-block__gal-image--50 @endif" >
                            <img src="{{$image['link']}}">
                        </figure>


                    @endforeach
                </div>
            @endif
        </section>

    @endforeach
@endif
