<template>
    <div class="my-chat">
        <div class="row">
            <div class="col-12">
                <div class="my-chat-item" v-for="(chat, index) in chats">
                    <span class="my-chat-item__title">Обсуждение к уроку "{{chat.name}}"</span>
                    <div class="my-chat-item-full">
                        <span class="my-chat-item__no">{{chat.unread_count}}</span>
                        <a class="my-chat-item__result" :href="'/profile/messages/' + chat.id">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        metaInfo: {
            title: 'Онлайн обучение - Мои тесты',
        },
        components: {

        },
        data() {
            return {
                chats:[],
            }
        },
        methods: {
            getChats() {
                axios.get('/api/profile/chats')
                .then((response) => {
                    this.chats = response.data;
                })
            },
        },
        mounted() {
            this.getChats();
        }
    }
</script>

<style lang="stylus" scoped>
    @import '../../../stylus/_mixins.styl'
    @import '../../../stylus/_rapture.styl'
    rupture.scale =       0    576px    768px    992px    1200px
    rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

    .b-breadcrumbs
        margin 50px 0px 20px 0px
        font-family 'RobotoLight'
        font-size 16px
        font-weight 400
        color #9F9F9F

    .my-chat__title
        margin-top 20px
        margin-bottom 30px
        font-family 'RubikRegular', sans-serif
        font-size rem(36px)
        font-weight 200
        color #4B4B4B
        +below(md)
            font-size rem(26px)

    .my-chat-item
        width 100%
        margin-bottom 20px
        padding 18px 10px
        border 1px solid #EBEBEB
        border-radius 5px
        background-color #fff
        box-shadow 0px 9px 45px -28px rgba(0,0,0,0.42)
        &:last-child
            margin-bottom 80px
        +below(sm)
            display flex
            flex-direction column
            justify-content center
        &__title
            font 400 rem(16px) "RobotoRegular", sans-serif
            color #4B4B4B
            +below(sm)
                display block
                text-align center
        &-full
            display inline-block
            +below(sm)
                text-align center
        &__sucsses
            margin 0px 15px
            padding 3px 10px
            border-radius 10px
            background-color #2ECC71
            font 400 rem(10px) "RobotoRegular", sans-serif
            color #fff
            +below(sm)
                display inline-block
                margin-top 10px
        &__no
            margin 0px 15px
            padding 3px 10px
            border-radius 10px
            background-color red
            font 400 rem(10px) "RobotoRegular", sans-serif
            color #fff
            +below(sm)
                display inline-block
                margin-top 10px
        &__result
            text-decoration underline
            font 400 rem(16px) "RobotoItalic", sans-serif
            color #4B4B4B

</style>

