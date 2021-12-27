<template>
    <div class="accardion-item" :class="open ? 'accardion-item--active' : ''">
        <div class="accardion-item__trigger"
            @click="open=!open"
            :class="open ? 'accardion-item__trigger--active' : ''"
            >
            <h2 class="accardion-item__title"> {{ title }} </h2>
            <svg class="accardion-item__icon"
                :class="open ? 'accardion-item__icon--active' : ''"
                >
                <use xlink:href="/images/sprite.svg#arrow_questation"></use>
            </svg>
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

.accardion-item
    position relative
    width 100%
    margin-top 20px
    margin-bottom 20px
    border-radius 15px
    box-shadow 0px 9px 33px -25px rgba(0,0,0,0.20)
    background-color #F9F9F9
    cursor pointer
    transition all .25s ease
    overflow hidden

    &--active
        background-color #F9F9F9

    &__trigger
        width 100%
        height 100%
        display flex
        justify-content space-between
        align-items center
        padding 25px 20px
        transition all .25s ease

.accardion-item__title
    margin 0
    line-height 1
    font-family 'RobotoRegular'
    font-size: 18px
    font-weight: 400
    color #4B4B4B

.accardion-item__icon
    width 20px
    height 20px
    transition all .25s ease
    &--active
        transform rotate(180deg)

.accardion-item__body
    display none
    margin-bottom 2rem
    padding 0px 20px 10px 20px
    &--active
        display block

.accardion-item__body--nopadding
    padding 0

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

