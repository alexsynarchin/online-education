<template>
    <div class="accardion-item" :class="open ? 'accardion-item--active' : ''">
        <div class="accardion-item__trigger"
            @click="open=!open"
            :class="open ? 'accardion-item__trigger--active' : ''"
            >
            <h2 class="accardion-item__title"> {{ title }} </h2>
            <div class="accardion-item__left">
                <span class="accardion-item__buy">Куплено {{ buyLessonCount }} урока</span>
                <svg class="accardion-item__icon"
                    :class="open ? 'accardion-item__icon--active' : ''"
                    >
                    <use xlink:href="/images/sprite.svg#arrow_questation"></use>
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
        title: {
            type: String,
            default: 'title'
        },
        buyLessonCount: {
            type: String,
            default: 'Не указано'
        },
        animation: {
            type: String,
            default: 'bottomToTop'
        }
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
    margin-top 2px
    margin-bottom 2px
    background-color #fff
    cursor pointer
    transition all .25s ease
    overflow hidden
    &__trigger
        width 100%
        height 100%
        display flex
        justify-content space-between
        align-items center
        padding 15px 20px
        border 1px dashed #E1E1E1
        border-radius 5px
        transition all .25s ease
        &--active
            background-color #F9F9F9
            border-radius 5px
            border-bottom none
    &__left
        +below(sm)
            display flex
            align-items center

.accardion-item__title
    margin 0
    line-height 1
    font-family 'RobotoItalic'
    font-size: 18px
    font-weight: 400
    color #4B4B4B
    +below(sm)
        font-size rem(16px)

.accardion-item__buy
    margin-right 15px
    font-family 'RobotoItalic'
    font-size: 16px
    font-weight: 40
    color #4B4B4B
    +below(sm)
        display none
        font-size rem(14px)

.accardion-item__icon
    width 20px
    height 20px
    transition all .25s ease
    &--active
        transform rotate(180deg)

.accardion-item__body
    border 1px solid #E1E1E1
    border-radius 5px

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

