<template>
    <div class="auth">
        <div class="login" v-if="signedIn">
            <div class="login-notification">
                <a href="/profile" class="notification-item">
                    <svg class="notification-item__icon">
                        <use xlink:href="/images/sprite.svg#login"></use>
                    </svg>
                </a>

                <div class="notification-item" @click="newPopup = !newPopup">
                    <svg class="notification-item__icon">
                        <use xlink:href="/images/sprite.svg#zvonok"></use>
                    </svg>
                    <span class="notification-item__count">0</span>
                    <Notification title="Сообщения" count="0" :class="newPopup ? 'notification-popup--open' : 'notification-popup--close'">
                        <!--<div class="notification-message">
                            <span class="notification-message__title">Обсуждение урока "Умножение положительных и отрицательн...</span>
                            <a href="#" class="notification-message__link">Перейти</a>
                        </div>
                        <div class="notification-message">
                            <span class="notification-message__title">Обсуждение урока "Умножение положительных и отрицательн...</span>
                            <a href="#" class="notification-message__link">Перейти</a>
                        </div>
                        <div class="notification-message">
                            <span class="notification-message__title">Обсуждение урока "Умножение положительных и отрицательн...</span>
                            <a href="#" class="notification-message__link">Перейти</a>
                        </div>-->
                    </Notification>
                </div>

                <a href="/profile/transactions" class="notification-item" >
                    <svg class="notification-item__icon">
                        <use xlink:href="/images/sprite.svg#ruble"></use>
                    </svg>

                </a>
            </div>

            <div class="login-in">
                <div class="login-in-prof" @click="isProfile = true">
                    <img class="login-in__avatar" v-if="user.avatar != null"  :src = user.avatar>
                    <img class="login-in__avatar" v-else src="/images/teacher-1.jpg" alt="">

                </div>

                <div class="mini-profile" :class="isProfile ? 'mini-profile--open' : 'mini-profile--close'">
                    <div class="mini-profile__close" @click="isProfile = !isProfile"></div>
                    <nav class="nav-profile">
                        <a href="/profile" class="nav-profile-item ">
                            <span class="nav-profile-item__text  nav-profile-item__text--big">{{user.name}} {{user.surname}}</span>
                        </a>
                        <a href="/profile" class="nav-profile-item nav-profile-item--border">
                            <svg class="nav-profile-item__icon">
                                <use xlink:href="/images/sprite.svg#home"></use>
                            </svg>
                            <span class="nav-profile-item__text">Мой профиль</span>
                        </a>
                        <section v-if="user.profile_type == 'student'">
                            <a href="/profile/education" class="nav-profile-item">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#srednee_obrazovanie"></use>
                                </svg>
                                <span class="nav-profile-item__text">Мои курсы</span>
                            </a>
                            <a href="/profile/teachers" class="nav-profile-item">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#login"></use>
                                </svg>
                                <span class="nav-profile-item__text">Мои преподаватели</span>
                            </a>
                            <a href="/profile/tests" class="nav-profile-item nav-profile-item--border">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#pencil-edit"></use>
                                </svg>
                                <span class="nav-profile-item__text">Мои тесты</span>
                            </a>
                        </section>
                        <section v-if="user.profile_type == 'teacher'">

                            <a href="/profile/course/create" class="nav-profile-item">
                                <i class="el-icon-plus nav-profile-item__icon" style="color: #fff; font-size: 20px"></i>
                                <span class="nav-profile-item__text">Добавить курс</span>
                            </a>
                            <a href="/profile/my-courses/active" class="nav-profile-item">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#srednee_obrazovanie"></use>
                                </svg>
                                <span class="nav-profile-item__text">Мои курсы</span>
                            </a>
                            <a href="/profile/students" class="nav-profile-item">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#login"></use>
                                </svg>
                                <span class="nav-profile-item__text">Мои ученики</span>
                            </a>
                            <a href="/profile/my-courses/draft" class="nav-profile-item">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#pencil-edit"></use>
                                </svg>
                                <span class="nav-profile-item__text">Черновики</span>
                            </a>
                            <a href="/profile/my-courses/moderate"
                               class="nav-profile-item nav-profile-item--border">
                                <svg class="nav-profile-item__icon">
                                    <use xlink:href="/images/sprite.svg#list"></use>
                                </svg>
                                <span class="nav-profile-item__text">Модерация</span>
                            </a>
                        </section>

                        <a href="/profile/messages" class="nav-profile-item">
                            <svg class="nav-profile-item__icon">
                                <use xlink:href="/images/sprite.svg#mail"></use>
                            </svg>
                            <span class="nav-profile-item__text">Сообщения</span>
                        </a>
                        <a href="/profile/notifications" class="nav-profile-item">
                            <svg class="nav-profile-item__icon">
                                <use xlink:href="/images/sprite.svg#zvonok"></use>
                            </svg>
                            <span class="nav-profile-item__text">Уведомления</span>
                        </a>
                        <a href="/profile/transactions" class="nav-profile-item nav-profile-item--border">
                            <svg class="nav-profile-item__icon">
                                <use xlink:href="/images/sprite.svg#ruble"></use>
                            </svg>
                            <span class="nav-profile-item__text">Транзакции</span>
                        </a>
                        <a href="#" class="nav-profile-item" @click.prevent="logout">
                            <svg class="nav-profile-item__icon">
                                <use xlink:href="/images/sprites.svg#sprite-logout"></use>
                            </svg>
                            <span class="nav-profile-item__text">Выйти</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div v-else class="btn-auth" role="button"  @click="showAuthModal">
            <svg class="btn-auth__svg">
                <use xlink:href="/images/sprite.svg#login"></use>
            </svg>
            <span class="btn-auth__title">
                Вход или Регистрация
            </span>
        </div>


    </div>
</template>
<script>

import Notification from './HeaderLoginNotificationPopup'
import EventBus from "../../EventBus";
export default {
    components: { Notification },
    data () {
        return {
            newPopup: false,
            isProfile: false,
        }
    },
    computed: {
        signedIn() {
            return window.App.signedIn;
        },
        user(){
           return  window.App.user
        }

    },
    methods: {
        showAuthModal() {
            EventBus.$emit('show-auth-modal')
        },
        logout: function () {
            axios.post('/logout').then(response => {
                if (response.status === 302 || 401) {
                    console.log('logout');
                    document.location.reload();
                } else {
                    // throw error and go to catch block
                }
            }).catch(error => {

            });
        }
    }
}
</script>

<style lang="stylus" scoped>

    @import '../../../stylus/_mixins.styl'
    @import '../../../stylus/_rapture.styl'

    rupture.scale =       0    576px    768px    992px    1200px
    rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

    .auth

        +below(md)

            display flex
            justify-content center
            margin 20px 0px

    .btn-auth
        display flex
        justify-content flex-end
        align-items center
        cursor pointer

    .btn-auth__svg
        width 17px
        height 17px
        margin-right 5px
        fill #6a89cc

    .btn-auth__title
        position relative
        top 2px
        font-weight: 500
        font-size rem(16px)
        color #000

    .login
        display flex

    .login-notification
        display flex
        justify-content space-between
        margin-right:20px

    .notification-item
        position relative
        size 40px
        display flex
        justify-content center
        align-items center
        border-radius 5px
        cursor pointer
        .notification-popup::before
            left calc(50% - 10px)
        &:not(:last-child)
            margin-right 15px
        &:nth-child(1)
            background-color #4A69BD
        &:nth-child(2)
            background-color #1ABC9C
        &:nth-child(3)
            background-color #FFCD02

        &__icon
            size 25px
            fill #fff
        &__count
            position absolute
            bottom -10px
            right -10px
            size 22px
            display flex
            justify-content center
            align-items center
            padding 5px
            border-radius 50%
            background-color #E74C3C
            font 400 rem(12px) 'RobotoMedium', sans-serif
            color #fff
            z-index 2

    .notification-item--open
        visibility visible
        opacity 0
        transition all .25s ease

    .notification-popup--close
        visibility hidden
        opacity 0
        transition all .25s ease

    .login-in
        position relative
        cursor pointer
        &-prof
            display flex
            justify-content flex-end
            align-items center
        &__avatar
            size 50px
            border-radius 50%
            margin-right 15px

        &__fullname
            width 60%


    .notification-message
        position relative
        display flex
        flex-direction column
        padding 20px
        transition all .25s ease
        &:not(:last-child)::after
            content ''
            position absolute
            bottom 0
            left 0
            width 100%
            height 1px
            border 1px dashed #fff
            opacity .25
        &:hover
            background-color #4764B1
        &__title
            font 400 rem(14px) 'RobooLight', sans-serif
            color #fff
        &__link
            margin-top 10px
            text-decoration underline
            font 400 rem(14px) 'RobotoLight', sans-serif
            color #fff !important

    .mini-profile
        position absolute
        top 60px
        right -85px
        width 250px
        padding 15px 0px
        border-radius 5px
        background-color #4A69BD
        z-index 999999
        &::before
            content ''
            position absolute
            top -19px
            left calc(50% - 10px)
            size 10px
            border 10px solid transparent
            border-bottom 10px solid #4A69BD

        &--open
            visibility visible
            opacity 1
            transition all .25s ease
        &--close
            visibility hidden
            opacity 0
            transition all .25s ease

        &__close
            position absolute
            top 10px
            right 12px
            size 25px
            display flex
            justify-content center
            align-items center
            z-index 222
            &::before
                content ''
                position absolute
                left 0
                width 100%
                height 2px
                background-color #fff
                transform rotate(-45deg)
            &::after
                content ''
                position absolute
                left 0
                width 100%
                height 2px
                background-color #fff
                transform rotate(45deg)

    .nav-profile
        display flex
        flex-direction column
        &-item
            position relative
            display flex
            align-items center
            padding 20px 20px 5px 20px
            // &::before
            //     content ''
            //     position absolute
            //     bottom -2px
            //     left 0
            //     width 100%
            //     height 2px
            //     background #4A69BD linear-gradient(90deg, #4A69BD 10%, #fff 50%, #4A69BD 90%)
            &--border
                padding-bottom 30px
                &::after
                    content ''
                    position absolute
                    bottom 10px
                    left 0
                    width 100%
                    height 1px
                    border 1px dashed #fff
                    opacity .35
            &__icon
                size 20px
                margin-right  15px
                fill #fff
            &__text
                font 600 rem(15px) 'Raleway', sans-serif
                color #fff
                &:hover
                    text-decoration underline
                 &--big
                    font-size:22px
</style>
