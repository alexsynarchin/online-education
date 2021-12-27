<template>
    <section class="banner" :style="{ backgroundImage: 'url(' + bannerImage + ')' }">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-sm-12 col-md-6 col-lg-4 h-100">
                    <div class="banner-des">
                        <h2 class="banner-des__title">Курсы дополнительного <br>образования</h2>
                        <p class="banner-des__short">
                            Получайте знания и развивайте
                            все ценные навыки.
                        </p>
                        <a href="/profile-courses" class="banner-des-link">
                            <span class="banner-des-link__text">Подробнее</span>
                            <svg class="banner-des-link__icon">
                                <use xlink:href="/images/sprite.svg#arrow-one"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data () {
        return {
            bannerImage: '/images/dop-eduk.jpg',
        }
    }
}
</script>

<style lang="stylus">

@import '../../../stylus/_mixins.styl'


.h-100
    height 100%

.banner
    width 100%
    height 465px
    background-size cover
    background-position center
    background-repeat no-repeat

.banner-des
    height 100%
    display flex
    flex-direction column
    justify-content center

.banner-des__title
    margin-bottom 20px
    font-family "RubikRegular", sans-serif
    font-size rem(28px)
    font-weight 200
    color #fff

.banner-des__short
    font-family "RobotoRegular", sans-serif
    font-size rem(20px)
    font-weight 200
    color #fff

.banner-des-link
    display flex
    align-items center
    transition all .25s ease
    &:hover
        .banner-des-link__icon
            left 10px

.banner-des-link__text
    margin-bottom 10px
    font-family "RobotoRegular", sans-serif
    font-size rem(15px)
    font-weight 200
    color #FFCD02
    text-decoration underline


.banner-des-link__icon
    position relative
    top -2px
    left 0
    width 40px
    height 40px
    margin-left 20px
    fill #FFCD02
    transition all .25s ease

</style>
