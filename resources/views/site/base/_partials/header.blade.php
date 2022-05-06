<header class="page-header">
    <section class="page-header-top">
        <div class="page-header-top__inner container">
            @include('site.base.header.top-nav')
            <div class="page-header-top__right">
                <ul class="page-header-top-nav__list">
                    <li class="page-header-top-nav__item">
                        <a class="page-header-top-nav__link header-top-nav__link--icon" href="{!! Config::get('settings.faq_link') !!}">
                            <svg class="page-header-top-nav__icon">
                                <use xlink:href="{{URL::asset('images/sprite.svg#help')}}"></use>
                            </svg>
                            Поддержка
                        </a>
                    </li>
                </ul>
                <div class="page-header-phone">
                    <svg class="page-header-phone__icon">
                        <use xlink:href="{{URL::asset('images/sprites.svg#sprite-phone_icon')}}"></use>
                    </svg>
                    <span>
                        {!! Config::get('settings.phone_header') !!}
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="page-header-main">
        <div class="container page-header-main__inner">
            <a href="/" class="page-header__logo">
                <img class="b-header__logo-img" src="{{asset('assets/site/images/logo.png')}}?ver=12" alt="logo" height="52px">
            </a>
            <div class="page-header__search">
                @include('site.base.header.headerSearch')
            </div>

        </div>
    </section>
    <section class="page-header-bottom container @auth @unlessrole('admin') page-header-bottom--auth @endunlessrole @endauth">
        <header-navigation></header-navigation>
        <header-login/>
    </section>
    <header-mobile></header-mobile>
</header>


