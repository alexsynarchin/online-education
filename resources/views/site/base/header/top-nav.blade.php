<nav class="page-header-top-nav">
       <ul class="page-header-top-nav__list">
        @foreach($top_nav as $item)
            <li class="page-header-top-nav__item">
                <a href="{{$item->link}}" class="page-header-top-nav__link">
                    {{$item->title}}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
