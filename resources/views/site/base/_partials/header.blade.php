<header class="page-header">
    <section class="page-header-top">
        <div class="page-header-top__inner container">
            @include('site.base.header.top-nav')
            <div class="page-header-top__right">
                <ul class="page-header-top-nav__list">
                    <li class="page-header-top-nav__item">
                        <a class="page-header-top-nav__link header-top-nav__link--icon" href="/faq">
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
                        8 800 555 35 35
                    </span>
                </div>
            </div>
        </div>
    </section>
    <section class="page-header-main">
        <div class="container page-header-main__inner">
            <a href="/" class="page-header__logo">
                <img class="b-header__logo-img" src="{{URL::asset('images/logo-3.png')}}?ver=12" alt="logo" width="167px">
            </a>
            <div class="page-header__search">
                @include('site.base.header.headerSearch')
            </div>

        </div>
    </section>
    <section class="page-header-bottom container">
        <header-navigation></header-navigation>
        <header-login/>
    </section>
    <div class="page-header__mobile container">
            <div class="col-12 col-lg-2 col-xl-2 d-flex justify-content-between align-items-center">
                <a class="m-mobile-item" href="#">
                    <svg class="m-mobile-item__icon">
                        <use xlink:href="{{URL::asset('images/sprite.svg#search')}}"></use>
                    </svg>
                    <span class="m-mobile-item__text">Поиск</span>
                </a>

                <a class="m-mobile-item" href="#" >
                    <svg class="m-mobile-item__icon">
                        <use xlink:href="{{URL::asset('images/sprite.svg#login')}}"></use>
                    </svg>
                    <span class="m-mobile-item__text">Войти</span>
                </a>
                <!--
                <a class="m-mobile-item m-mobile-item--profile" href="javascript:;">
                    <img class="m-mobile-item__img" src="{{URL::asset('images/teacher-1.jpg')}}" alt="Учитель">
                    <span class="m-mobile-item__text">Профиль</span>
                </a>-->

                <div class="m-mobile-item">
                    <div class="m-btn">
                        <span class="m-btn__line"></span>
                    </div>
                    <span class="m-mobile-item__text">Меню</span>
                </div>
            </div>
    </div>
</header>


