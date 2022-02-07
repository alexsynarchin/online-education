<template>
    <section class="chat">
        <div class="messages-item" v-for="(message,index) in messages">
            <div class="messages-item__head">
                <img class="messages-item__avatar" :src="message.user_avatar" alt="">
                <div class="messages-item-des">
                    <div class="messages-item-user">
                        <div class="messages-item-prof">
                            <a href="#" class="messages-fullname">{{message.user_full_name}}</a>
                        </div>
                        <div class="messages-item-data">
                            <span class="messages-item-data__time">{{message.formatted_date}}</span>
                        </div>
                    </div>
                    <div class="messages-comment">
                        <p class="messages-comment__text">
                            {{message.text}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <el-form :model="sendMsg" label-position="top" :rules="rules" ref="sendMsg" class="mb-3">
            <el-form-item label="Новое сообщение" prop="text">
                <el-input
                    type="textarea"
                    :rows="3"
                    placeholder="Введите сообщение"
                    v-model="sendMsg.text">
                </el-input>
            </el-form-item>
            <el-button type="success" @click.prevent="sendMessage('sendMsg')">Отправить</el-button>
        </el-form>

    </section>
</template>
<script>
    export default {
        props:['chat'],
        data(){
            return {
                sendMsg:{
                    text:""
                },
                messages:[],
                rules:{
                    text:{required:true,message:'Введите текст сообщения'}
                }
            }
        },
        mounted(){
            this.getMessages();
        },
        methods:{
            getMessages()
            {
                axios.get('/api/profile/chats/'+ this.chat.id + '/messages')
                    .then((response)=>{
                        this.messages = response.data;
                    })
                    .catch((error) =>{

                    })
            },
            sendMessage(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        axios.post('/api/profile/chats/' + this.chat.id + '/send-message',{message:this.sendMsg.text})
                            .then((response)=>{
                                this.$refs[formName].resetFields();
                                console.log(response.data)
                                this.getMessages();
                            })
                            .catch((error)=>{

                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
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

    .b-breadcrumbs
        margin 50px 0px 20px 0px
        font-family 'RobotoLight'
        font-size 16px
        font-weight 400
        color #9F9F9F

    .b-messages__title
        margin-top 20px
        margin-bottom 30px
        font-family 'RubikRegular', sans-serif
        font-size rem(36px)
        font-weight 200
        color #4B4B4B
        +below(md)
            font-size rem(26px)

    .messages-item
        margin-bottom 30px
        padding 15px
        border-radius 5px
        transition all .25s ease
        cursor pointer
        &:hover
            background-color #EBF0FB

    .messages-item__head
        display flex
        +below(md)
            flex-direction column

    .messages-item__avatar
        size 50px
        margin-right 20px
        border-radius 50%
        +below(md)
            margin-bottom 20px

    .messages-item-des
        width 95%
        +below(md)
            width 100%
        &__theme
            margin 8px 0px
            font 400 rem(14px) "RobotoMedium", sans-serif
            color #9A9A9A

    .messages-item-user
        display flex
        justify-content space-between
        align-items center
        +below(md)
            flex-direction column
            align-items flex-start


    .messages-item-prof
        display flex

    .messages-item-data
        color #878787
        &__time
            margin-right 15px
            font 600 rem(14px) "RobotoRegular", sans-serif
        &__year
            font-size rem(14px)

    .messages-fullname
        margin-right 10px
        font 400 rem(14px) "RobotoRegular", sans-serif
        text-decoration underline
        color #4B4B4B
        +below(md)
            margin-bottom 15px
    .messages-count
        position relative
        size 18px
        display flex
        justify-content center
        align-items center
        border-radius 50%
        background-color #E74C3C
        font 400 rem(10px) "RobotoMedium", sans-serif
        color #fff
    .messages-comment
        display flex
        align-items center
        margin-top 10px
        font 400 rem(14px) "RobotoRegular", sans-serif
        color #4B4B4B
        +below(md)
            flex-direction column
            align-items flex-start
        &__avatar
            size 40px
            margin-right 10px
            border-radius 50%
            +below(md)
                margin-bottom 10px
        &__text
            margin 0

    .message-btn-wrap
        +below(md)
            display flex
            justify-content center

    .message-more-btn
        display inline-block
        margin 40px 0px
        padding 15px 50px
        border-radius 5px
        background-color #6A89CC
        font 400 rem(16px) "RubikLight", sans-serif
        color #fff
        transition all .25s ease
        &:hover
            background-color #5A79BC
            color #fff !important

</style>
