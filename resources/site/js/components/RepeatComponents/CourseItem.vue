<template>
    <div class="accardion-item" :class="open ? 'accardion-item--active' : ''">
        <div class="accardion-item__trigger"
            @click="open=!open"
            :class="open ? 'accardion-item__trigger--active' : ''"
            >
            <h2 class="accardion-item__title"> {{course.title}} </h2>
            <div class="accardion-left">
                <a class="accardion-item__link" :href="'/profile/my-courses/' + course.slug" >
                    <svg class="accardion-item__link_icon">
                        <use xlink:href="/images/sprite.svg#arrow-forward"></use>
                    </svg>
                </a>
                <svg class="accardion-item__icon"
                    :class="open ? 'accardion-item__icon--active' : ''"
                    >
                    <use xlink:href="/images//sprite.svg#arrow_questation"></use>
                </svg>
            </div>
        </div>
        <transition :name="animation">
            <div class="accardion-item__body"
                v-show="open"
                :class="open ? 'accardion-item__body--active' : ''"
                >
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        course:{

        },
        animation: {
        type: String,
        default: 'bottomToTop'
    },
    },
    data() {
        return {
            open: false
        }
    }
}
</script>

<style lang="stylus" scoped>
@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'
rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.accardion-item
    position relative
    width 100%
    margin-top 20px
    margin-bottom 20px
    border-radius 15px
    box-shadow 0px 9px 75px -25px rgba(0,0,0,0.20)
    background-color #fff
    cursor pointer
    transition all .25s ease
    overflow hidden
    &:hover .accardion-item__link
        opacity 1
    &:hover .accardion-item__link_icon
        transform translateX(0)
    &__trigger
        width 100%
        height 100%
        display flex
        justify-content space-between
        align-items center
        padding 15px 20px
        transition all .25s ease

.accardion-item__title
    margin 0
    line-height 1
    font-family 'RobotoRegular'
    font-size: rem(18px)
    font-weight: 400
    color #4B4B4B
    +below(sm)
        font-size rem(16px)

.accardion-left
    display flex
    justify-content center
    align-items center
    overflow hidden

.accardion-item__link
    display flex
    justify-content center
    align-items center
    padding 12px 18px
    margin-right 20px
    border-radius 39%
    background-color #FFCD02
    opacity 0
    transition opacity .25s ease
    +below(sm)
        display none
    &_icon
        width 18px
        height 18px
        transition all .25s ease
        transform translateX(-200%)
    &:hover
        background-color #FFCD02
        .accardion-item__link_icon
            fill #fff

.accardion-item__icon
    width 20px
    height 20px
    transition all .25s ease
    &--active
        transform rotate(180deg)


.bottomToTop-enter-active
    animation bottomToTop .5s forwards
.bottomToTop-leave-active
    animation bottomToTop .5s reverse

@keyframes bottomToTop
    0%
        opacity 0
        transform: translateY(100%)

    100%
        transform: translateY(0)

</style>

