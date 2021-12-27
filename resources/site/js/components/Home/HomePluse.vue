<template>
    <section class="pluse">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="pluse__title">
                        Ваши ценности в Educ All
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-4" v-for="(pluseCartItem, index) in pluseCarts" :key="index">
                    <div class="pluse-cart-anim pluse-cart-anim--hover">
                        <div class="pluse-cart">
                            <div class="pluse-cart__face pluse-cart__face--front" :style="{ backgroundImage: 'url(' + pluseCartItem.src + ')' }"></div>
                            <div class="pluse-cart__face pluse-cart__face--back">
                                <h2 class="pluse-cart__face_title"> {{ pluseCartItem.title }} </h2>
                                <p class="pluse-cart__face_des">
                                    С другой стороны рамки и место обучения кадров обеспечивает
                                    широкому кругу (специалистов) участие в формировании
                                    системы обучения кадров, соответствует насущным потребностям.
                                    Значимость этих проблем настолько очевидна, что рамки и место
                                    обучения кадров в значительной степени обуславливает создание форм развития.
                                </p>
                                <a href="#" class="pluse-cart__link">
                                    <span class="pluse-cart__link_more">Подробнее</span>
                                    <svg class="pluse-cart__link_icon">
                                        <use xlink:href="/images/sprite.svg#arrow-one"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="pluse-cart__loader">
                                <svg class="pluse-cart__loader_icon">
                                    <use xlink:href="/images/sprite.svg#rotate"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h2 class="pluse-cart-title">{{ pluseCartItem.title }}</h2>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data () {
        return {
            pluseCarts: [
                {
                    src: '/images/1_.jpg',
                    title: 'Преподавателям'
                },
                {
                    src: '/images/2_.jpg',
                    title: 'Ученикам'
                },
                {
                    src: '/images/3_.jpg',
                    title: 'Дополнительное образование'
                }
            ]
        }
    }
}
</script>

<style lang="stylus">

@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.pluse
    padding 90px 0px

.pluse__title
    margin-bottom 10px
    font-family "RubikRegular", sans-serif
    font-size rem(25px)
    font-weight 200
    +below(md)
        font-size rem(22px)


.pluse-cart-anim
    margin-bottom 30px

.pluse-cart-anim--hover
    &:hover
        .pluse-cart
            transform: translateX(-100%) rotateY(-180deg)

.pluse-cart
    position relative
    width 100%
    height 490px
    margin-bottom 15px
    cursor: pointer
    transform-style: preserve-3d
    transform-origin: center right
    transition: transform 1s
    perspective 500px



.pluse-cart__face
    position absolute
    top 0
    left 0
    width 100%
    height 100%
    border-radius 20px
    box-shadow -2px 5px 36px -6px rgba(0,0,0,0.3)
    background-size cover
    background-repeat no-repeat
    background-position center
    backface-visibility hidden

.pluse-cart__face_title
    margin-bottom 20px
    font-family "RobotoRegular", sans-serif
    font-size rem(20px)
    font-weight 400

.pluse-cart__face_des
    font-family "RobotoRegular", sans-serif
    font-size rem(16px)
    font-weight 200

.pluse-cart__link
    display flex
    align-items center
    transition all .25s ease
    &:hover
        .banner-des-link__icon
            left 10px

.pluse-cart__link_more
    margin-bottom 10px
    font-family "RobotoRegular", sans-serif
    font-size rem(15px)
    font-weight 200
    color #3D3D3D
    text-decoration underline


.pluse-cart__link_icon
    position relative
    top -2px
    left 0
    width 40px
    height 40px
    margin-left 20px
    fill #3D3D3D
    transition all .25s ease

.pluse-cart__face--front
    z-index 2

.pluse-cart__face--back
    display flex
    flex-direction column
    justify-content space-between
    padding 20px
    background #ffffff
    transform: rotateY( 180deg )
    z-index 3

.pluse-cart-title
    font-family "RubikRegular", sans-serif
    font-size rem(25px)
    font-weight 200


.pluse-cart__loader
    position absolute
    top 17px
    right 17px
    size 60px
    display flex
    justify-content center
    align-items center
    border-radius 50%
    background-color #fff
    box-shadow -2px 5px 36px -6px rgba(0,0,0,0.3)
    z-index 2



.pluse-cart__loader_icon
    position relative
    left 1px
    size 45px


</style>
