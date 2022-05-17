<template>
    <section class="mb-4">
        <div class="b-breadcrumbs">
            <ul class="breadcrumb">
                <li class="breadcrumb__item">
                    <a  href="/" class="breadcrumb__link">Главная</a>
                </li>
                <li class="breadcrumb__item">
                    <a  href="/profile/my-courses/active"  class="breadcrumb__link">Мои курсы</a>
                </li>
                <li class="breadcrumb__item">
                    <a href="/profile" class="breadcrumb__link">Профиль</a>
                </li>
                <li class="breadcrumb__item">
                    <a :href="'/profile/courses/' + slug" class="breadcrumb__link">{{course.title}}</a>
                </li>
                <li class="breadcrumb__item">
                    {{lesson.title}} : редактирование
                </li>
            </ul>
        </div>
        <h1 class="b-profile-user__title">{{lesson.title}} : редактирование</h1>
        <el-alert
            v-if="lesson.status === 3"
            v-for="(item, index) in lesson.messages"
            :key="item.id"
            title="Причина отклонения урока:"
            class="mb-4"
            :description="item.text"
            type="error">
        </el-alert>
        <el-tabs v-model="activeTab"  class="edu-tabs">
            <el-tab-pane label="Урок" name="description">
                <description-form :lesson="lesson"></description-form>
                <content-form
                    :ContentData ="contentData"
                    :errors="errors"
                    v-if="loaded"></content-form>
                <el-button style="margin-right: 2rem"  type="success" @click.prevent="updateLesson">Сохранить</el-button>
                <el-button  type="info" @click.prevent="canselUpdate">Отменить</el-button>
            </el-tab-pane>
            <el-tab-pane label="Тест к уроку" name="test">
                <test-form :data="test"  @update="updateTest"  v-if="loaded"></test-form>
            </el-tab-pane>
            <el-tab-pane label="Чат с модератором" name="chat">
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
                    <el-form :model="sendMsg" label-position="top"  ref="sendMsg" class="mb-3">
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

    </section>
</template>
<script>
    import DescriptionForm from "./components/form";
    import ContentForm from "./components/ContentForm";
    import TestForm from "./components/LessonTest/TestForm";
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        components:{
            DescriptionForm, ContentForm, TestForm,
        },
        props: {
            slug:{
                type:String
            },
            lesson_slug: {
                type:String
            }
        },
        data() {
            return {
                activeTab:'description',
                loaded:false,
                contentData:{},
                course: {},
                lesson: {},
                test: {},
                messages: [],
                sendMsg:{
                    text:"",
                },
                errors: new Errors(),
            }
        },
        methods: {
            sendMessage(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        axios.post('/api/profile/edu-chat/' + this.lesson.id + '/send', {type:'lesson', message:this.sendMsg.text})
                            .then((response)=>{
                                this.$refs[formName].resetFields();
                                this.getMessages();
                            })
                            .catch((error)=>{

                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getMessages() {
                axios.get('/api/profile/edu-chat/' + this.lesson.id + '/messages', {params:{type:'lesson'}})
                    .then ((response) => {
                        this.messages = response.data;
                    })
            },
            canselUpdate() {
                window.location.href = '/profile/courses/' + this.slug
            },
            updateLesson() {
                axios.post('/api/profile/lesson/update', {course:this.course, lesson:this.lesson, test:this.test, contentData:this.contentData, updateTest:false})
                .then((response) => {
                    window.location.href = '/profile/courses/' + this.slug
                })
                    .catch((error) => {
                        this.isLoading = false;
                        this.errors.record(error.response.data.errors);
                    })
            },
            getData() {
                axios.get('/api/profile/' + this.slug + '/' + this.lesson_slug + '/show')
                .then((response) => {
                    this.course = response.data.course;
                    this.lesson = response.data.lesson;
                    this.getMessages();
                    this.contentData = {
                        text:response.data.lesson.content.text,
                        type_video: response.data.lesson.type_video,
                        type_text: response.data.lesson.type_text,
                        type_audio: response.data.lesson.type_audio,
                        type_image: response.data.lesson.type_image
                    }
                    this.test = response.data.test;
                    this.loaded = true;
                })
            },
            updateTest() {
                axios.post('/api/profile/lesson/update', {course:this.course, lesson:this.lesson, test:this.test, contentData:this.contentData,updateTest:true})
                    .then((response) => {

                    })
            }
        },
        mounted() {
            this.getData();

        }
    }
</script>
