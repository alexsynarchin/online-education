<template>
    <div class="notification-popup">
        <div class="notification-popup__header">
            <div class="notification-popup-close" title="Закрыть"></div>
            <div class="notification-popup-title">
                <span class="notification-popup-title__text">{{ title }}</span>
                <span class="notification-popup-title__count">{{ count }}</span>
            </div>
        </div>
        <div class="notification-popup__body">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: 'title'
        },
        count: {
            type:Number,
            default: 0
        }
    },
}
</script>

<style lang="stylus" scoped>

@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.notification-popup
    position absolute
    top 60px
    width 470px
    padding 20px 0px
    border-radius 5px
    background-color #4A69BD
    z-index 999999
    &::before
        content ''
        position absolute
        top -19px
        left 0
        size 10px
        border 10px solid transparent
        border-bottom 10px solid #4A69BD
    &__header
        position relative
        padding 0px 20px 20px 20px
        &::after
            content ''
            position absolute
            bottom 0
            left 0
            width 100%
            height 1px
            background #fff
            opacity .55
    &-close
        position absolute
        top -10px
        right 10px
        size 20px
        display flex
        align-items center
        cursor pointer
        &::after
            content ''
            position absolute
            left 0
            width 100%
            height 2px
            background-color #fff
            transform rotate(45deg)
        &::before
            content ''
            position absolute
            left 0
            width 100%
            height 2px
            background-color #fff
            transform rotate(-45deg)
    &-title
        display flex
        align-items center
        &__text
            margin-right 15px
            font 400 rem(14px) 'RobotoMedium', sans-serif
            color #fff
        &__count
            size 22px
            display flex
            justify-content center
            align-items center
            padding 5px
            border-radius 50%
            background-color #E74C3C
            font 400 rem(12px) 'RobotoMedium', sans-serif
            color #fff
            z-index 11
</style>
