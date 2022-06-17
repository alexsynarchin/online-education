<template>
    <section v-if="loaded">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h3 class="course-item__title d-flex align-items-center">
                <span style="margin-right: 10px">{{lesson.title}}</span>
                <status :active_status="lesson.status"></status>
            </h3>

            <div class="lesson__btns d-flex justify-content-end">
                <el-button type="success" @click.prevent="lessonChangeStatus(2)" v-if="lesson.status != 2">Опубликовать</el-button>
                <el-button type="warning" @click.prevent="lessonChangeStatus(1)" v-if="lesson.status === 2">Снять с публикации</el-button>
                <el-button type="danger" @click.prevent="dialogCancel = true" v-if="lesson.status === 1">Отклонить</el-button>
            </div>
        </div>
        <el-badge :value="unreadMsgCount" class="item mt-2 mb-2">
            <el-button  type="primary" @click="openChat">Чат с преподавателем</el-button>
        </el-badge>
        <el-tabs v-model="activeTab"  class="edu-tabs">
            <el-tab-pane label="Основная информация" name="description">
                <description-form :lesson="lesson"></description-form>
                <h3 class="mt-3 mb-3">
                    Тест к уроку
                </h3>
                <test-form :data="test"    v-if="loaded"></test-form>
            </el-tab-pane>
            <el-tab-pane label="Содержимое урока" name="content">
                <content-form :errors="errors" :data="contentData" v-if="loaded"></content-form>
            </el-tab-pane>
        </el-tabs>
        <div v-if="activeTab != 'chat'">
            <el-button style="margin-right: 2rem"  type="success" @click.prevent="updateLesson">Сохранить</el-button>
            <el-button  type="info" @click.prevent="canselUpdate">Отменить</el-button>
        </div>

        <el-dialog title="Отклонить Урок" width="40%" :visible.sync="dialogCancel" append-to-body>
            <el-form :model="cancelForm" ref="cancelForm" :rules="rules_cancel">
                <el-form-item label="Причина отклонения урока" prop="text">
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


        <el-dialog
            title="Чат с преподавателем"
            :visible.sync="chatVisible"
            width="50%"
            append-to-body
            :before-close="handleCloseChat">
            <section class="chat">
                <div class="messages-item" v-for="(message,index) in lesson.messages">
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
            <span slot="footer" class="dialog-footer">
    <el-button @click="chatVisible = false">Закрыть</el-button>
  </span>
        </el-dialog>
    </section>
</template>
<script>
import DescriptionForm from "./components/form";
import ContentForm from "./components/ContentForm";
import TestForm from "./components/LessonTest/TestForm";
import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props: {
          id: {
              type:Number,
              required:true,
          },
            course_status: {},
        },
        components: {
            DescriptionForm, ContentForm, TestForm,
        },
        computed: {
            unreadMsgCount:function (){
                let unread = this.lesson.messages.filter(obj => {
                    return (obj.read === 0) && (obj.sender_id === this.lesson.user_id)
                })
                return unread.length
            }
        },
        data() {
            return {
                contentData: {},
                errors: new Errors(),
                chatVisible:false,
                sendMsg:{
                    text:"",
                },
                rules:{
                    text:{required:true,message:'Введите текст сообщения'}
                },
                activeTab:'description',
                course: {},
                test: {},
                lesson: {},
                loaded:false,
                dialogCancel:false,
                cancelForm:{
                    text:""
                },
                rules_cancel:{
                    text:[{required:true,message:'Введите причину отклонения Урока'}]
                }
            }
        },
        methods: {
            openChat() {
                this.chatVisible = true;
                axios.post('/api/admin/edu-chat/read', {type:'lesson', id:this.lesson.id})
                    .then((response) => {
                        this.lesson.messages.forEach((item, i) => {
                        if((item.read === 0) && (item.sender_id === this.lesson.user_id)) {
                            console.log(item.read);
                            this.lesson.messages[i].read = 1;
                        }
                        });
                    })
            },
            handleCloseChat() {
                this.chatVisible = false;
            },
            sendMessage(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        axios.post('/api/admin/lesson/' + this.lesson.id + '/send-message', {type:'lesson', message:this.sendMsg.text})
                            .then((response)=>{
                                this.$refs[formName].resetFields();
                                this.lesson.messages.push(response.data);
                            })
                            .catch((error)=>{

                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getData() {
                axios.get('/api/admin/lesson/show/' + this.id)
                .then((response) => {
                    this.course = response.data.course;
                    this.lesson = response.data.lesson;
                    this.test = response.data.test;
                    this.contentData = {
                        vk_url: response.data.lesson.vk_url,
                        youtube_url:response.data.lesson.youtube_url,
                        text:response.data.lesson.content.text,
                        type_video: response.data.lesson.type_video,
                        type_text: response.data.lesson.type_text,
                        type_audio: response.data.lesson.type_audio,
                        type_image: response.data.lesson.type_image
                    }
                    this.loaded = true;

                })
            },
            canselUpdate() {
                this.$emit('close');
            },
            updateLesson() {
                axios.post('/api/profile/lesson/update', {course:this.course, lesson:this.lesson, contentData:this.contentData, test:this.test, updateTest:true})
                    .then((response) => {
                        this.$emit('close', this.lesson.title);
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            },
            lessonChangeStatus(status) {
                if(status===2 && this.course_status !==2 ) {
                    this.$notify.error({
                        title: 'Нельзя опубликовать урок в неопубликованном курсе',
                    });
                } else {
                    axios.post('/api/admin/lesson/change-status', {id:this.lesson.id, status:status})
                        .then((response)=>{
                            this.lesson.status = status;
                            this.$emit('change-status',status);
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
                }

            },
            publishCancel(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        ///lesson-{id}/cancel-message
                        axios.post('/api/admin/lesson/'+ this.lesson.id +'/cancel-message',{message:this.cancelForm.text})
                            .then((response) => {
                                console.log(response.data);
                                this.dialogCancel = false;
                                this.lessonChangeStatus(3);
                            })
                            .catch((error) => {

                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>
