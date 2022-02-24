<template>
    <section class="page-header__mobile">
        <div class="container">
            <div class="col-12 col-lg-2 col-xl-2 d-flex justify-content-between align-items-center">
                <a class="m-mobile-item" href="#">
                    <svg class="m-mobile-item__icon">
                        <use xlink:href="/images/sprite.svg#search"></use>
                    </svg>
                    <span class="m-mobile-item__text">Поиск</span>
                </a>

                <a class="m-mobile-item" href="#" >
                    <svg class="m-mobile-item__icon">
                        <use xlink:href="/images/sprite.svg#login"></use>
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
        <section class="mobile-panel">

        </section>
    </section>

</template>
<script>
    export default {
        data() {

        }
    }
</script>
