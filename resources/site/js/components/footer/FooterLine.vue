<template>
    <div class="b-footer-line-down">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="b-footer-line">
                        <div class="b-footer-copyright">
                            <p class="b-footer-copyright__text" style="">
                                © 2019  АНО ОСВДО "ОБРАЗОВАТЕЛЬНЫЙ".
                            </p>
                        </div>

                        <div class="b-footer-development">
                            <span class="b-footer-development__first">
                                Создан совместно с
                            </span>
                            <a class="b-footer-development__link" href="http://pandaworks.ru/">
                                <span class="b-footer-development__link_first">
                                    панда
                                </span>
                                воркс
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="stylus" >

@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

p
    margin 0

.b-footer-line-down
    display flex
    align-items center
    margin-top 20px
    background-color #4A69BD

.b-footer-line
    width 100%
    display flex
    justify-content space-between
    padding 20px 0px
    +below(lg)
        flex-direction column


.b-footer-copyright
    display flex
    align-items center
    font-family "RubikRegular", sans-serif
    font-weight 400
    font-size rem(16px)
    color #fff
    +below(lg)
        justify-content center
    +below(sm)
        text-align center

.b-footer-development
    +below(lg)
        display flex
        justify-content center
        align-items center
    +below(sm)
        flex-direction column
        margin-top 10px

.b-footer-development__first
    margin 3px 25px 0px 0px
    font-family "RubikRegular", sans-serif
    font-weight 400
    font-size rem(16px)
    color #fff
    +below(sm)
        margin-right 0px

.b-footer-development__link
    margin-right 25px
    font-family "RubikRegular", sans-serif
    font-weight 700
    font-size rem(20px)
    color #fff
    transition all .25s ease
    +below(sm)
        position relative
        left 3px
        margin-right 0px
</style>

