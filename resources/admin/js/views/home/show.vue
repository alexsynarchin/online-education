<template>
    <section class="lesson-page" style="max-width: 1160px">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item><a href="/admin">Курсы</a></el-breadcrumb-item>
            <el-breadcrumb-item>{{course.title}}</el-breadcrumb-item>
        </el-breadcrumb>
        <el-tabs type="card" class="mt-4">
            <el-tab-pane label="Курс">
                <section class="lesson__heading d-flex align-items-center justify-content-between">
                    <h1 class="teacher-lesson__title">{{course.title}}</h1>
                    <div class="lesson__btns d-flex justify-content-end">
                        <el-button type="success" @click.prevent="courseChangeStatus(2)" v-if="course.status != 2">Опубликовать</el-button>
                        <el-button type="warning" @click.prevent="courseChangeStatus(1)" v-if="course.status === 2">Снять с публикации</el-button>
                        <el-button type="danger" @click.prevent="dialogCancel = true" v-if="course.status === 1">Отклонить</el-button>
                        <el-button type="primary" @click="editCourse(course.slug)">Редактировать курс</el-button>
                    </div>
                </section>
                <el-tabs type="card" class="mb-3" >
                    <el-tab-pane label="Основная информация">
                        <Description :course="course" v-if="course.author"></Description>
                    </el-tab-pane>
                </el-tabs>
                <el-tabs type="card" >
                    <el-tab-pane label="Уроки">
                        <lessons-list :lessons="course.lessons" v-if="loaded"></lessons-list>
                    </el-tab-pane>
                </el-tabs>
            </el-tab-pane>
            <el-tab-pane label="Чат с преподавателем">
                <section class="chat">
                    <div class="messages-item" v-for="(message,index) in course.messages">
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
            </el-tab-pane>
        </el-tabs>

        <el-dialog title="Отклонить Курс" width="40%" :visible.sync="dialogCancel" >
            <el-form :model="cancelForm" ref="cancelForm" :rules="rules_cancel">
                <el-form-item label="Причина отклонения Курса" prop="text">
                    <el-input
                        type="textarea"
                        :rows="4"
                        placeholder="Введите сообщение"
                        v-model="cancelForm.text">
                    </el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="publishCancel('cancelForm')">Отклонить</el-button>
                <el-button type="primary" @click="dialogCancel  = false">Отменить</el-button>
            </span>
        </el-dialog>
    </section>
</template>
<script>
import Description from "./components/Description";
import LessonsList from "@/admin/js/components/lessons-list/index";
    export default {
        props:['id'],
        components:{
            Description, LessonsList,
        },
        data() {
            return {
                sendMsg:{
                    text:"",
                },
                rules:{
                    text:{required:true,message:'Введите текст сообщения'}
                },
                courseModal:false,
                loaded:false,
                course: {},
                dialogCancel:false,
                cancelForm:{
                    text:""
                },
                rules_cancel:{
                    text:[{required:true,message:'Введите причину отклонения Курса'}]
                }
            }
        },
        methods: {
            sendMessage(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        axios.post('/api/admin/course/' + this.course.id + '/send-message', {type:'course', message:this.sendMsg.text})
                            .then((response)=>{
                                this.$refs[formName].resetFields();
                                this.course.messages.push(response.data);
                            })
                            .catch((error)=>{

                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            editCourse(slug){
                window.location.href = '/admin/courses/'+ slug + '/edit'
            },
            getData() {
                axios.get('/api/admin/courses/' + this.id)
                .then((response) => {
                    this.course = response.data;
                    this.loaded = true;
                })
            },
            publishCancel(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        ///lesson-{id}/cancel-message
                        axios.post('/api/admin/course/'+ this.course.id +'/cancel-message',{message:this.cancelForm.text})
                            .then((response) => {
                                console.log(response.data);
                                this.dialogCancel = false;
                                this.courseChangeStatus(3);
                            })
                            .catch((error) => {

                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            courseChangeStatus(status) {
                axios.post('/api/admin/course/change-status', {id:this.course.id, status:status})
                    .then((response)=>{
                        this.course.status = status;
                        this.getData();
                        this.$notify({
                            title: 'Отлично',
                            message: response.data,
                            type: 'success',
                            duration:4000
                        });
                    })
                    .catch((error)=>{
                        console.log(error)
                    });
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>
<style lang="stylus">

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


</style>
