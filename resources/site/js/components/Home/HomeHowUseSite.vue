<template>
    <section class="b-how-use">
        <div class="container">
            <div class="row how-use-header">
                <div class="col">
                    <h2 class="how-use-header__title">
                        Как пользоваться сайтом
                    </h2>
                    <p class="how-use-header__des">
                        Мы выписали два основных способа,<br>
                        чтобы вы могли уже сейчас перейти к обучению
                    </p>
                </div>
            </div>
            <div class="row how-use-list">
                <div class="col how-use-list__item">
                    <div class="b-use-card">
                        <h2 class="b-how-use-card__title">
                            Первый способ
                        </h2>
                    </div>
                    <div class="b-how-use-des">
                        <div class="b-how-use-des__text">
                            <p>
                                С начало выберите «тип образовательного учреждения»,«предмет», и «тему», а затем
                                «преподавателя», по параметрам: цена и рейтинг.<br>
                                В некоторых случаях рекомендуем обратить внимание <br>
                                и на биографию.<br>
                            </p>
                            <p>
                                Преподаватель, в рамках урока, будет помогать вам <br>
                                выполнять задания.
                            </p>
                        </div>
                        <a href="/how-it-works" class="b-how-use-des-link">
                            <span class="b-how-use-link__text">
                                Подробней о возможностях
                            </span>
                            <svg class="b-how-use-link__icon">
                                <use xlink:href="/images/sprite.svg#arrow-one"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col how-use-list__item">
                    <div class="b-use-card">
                        <h2 class="b-how-use-card__title">
                            Второй способ
                        </h2>
                    </div>
                    <div class="b-how-use-des">
                        <div class="b-how-use-des__text">
                            <p>
                                Знаете ФИО преподавателя, или название учебного <br> заведения? Воспользуйтесь поиском
                                в верхней части<br> сайта.
                            </p>
                        </div>
                        <a href="/how-it-works" class="b-how-use-des-link">
                            <span class="b-how-use-link__text">
                                Подробней о возможностях
                            </span>
                            <svg class="b-how-use-link__icon">
                                <use xlink:href="/images/sprite.svg#arrow-one"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>



<style lang="stylus" scoped>


@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-how-use
    padding 90px 0px

.how-use-header
    text-align center
    margin-bottom 30px
    &__title
        font-family "RubikRegular", sans-serif
        font-size rem(32px)
        color #4B4B4B
    &__des
        font-family "RobotoRegular", sans-serif
        font-size rem(16px)
        color #4B4B4B


.b-use-card
    display flex
    align-items center
    padding 15px 0px
    background-color #99AEDB
    border-top-right-radius 20px
    border-top-left-radius 20px

.b-how-use-card__title
    position relative
    top 5px
    margin-left 40px
    margin-bottom 0
    font-family "RobotoRegular", sans-serif
    font-weight 200
    font-size rem(25px)
    color #FFFFFF
    line-height 1

.b-how-use-des
    height 330px
    display flex
    flex-direction column
    justify-content space-between
    padding 20px 40px
    border 1px solid #DFDFDF
    border-bottom-right-radius 20px
    border-bottom-left-radius 20px
    +below(lg)
        height auto

.b-how-use-des-link
    display flex
    align-items center
    &:hover .b-how-use-link__icon
        transform translateX(10px)


.b-how-use-link__text
    font-family "RobotoMedium", sans-serif
    font-size rem(16px)
    font-weight 600
    text-decoration underline
    color #000

.b-how-use-link__icon
    width 40px
    height 40px
    margin-left 10px
    transition all .25s ease

.how-use-list__item
    +below(lg)
        margin-bottom 30px
</style>
