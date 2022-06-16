<template>
    <section class="mb-4">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile/my-courses/active">Мои курсы</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" :href="'/profile/courses/' + slug">{{course.title}}</a>
            </li>
            <li class="breadcrumb__item">
                Новый урок
            </li>
        </ul>
        <div class="d-flex align-items-center justify-content-between">
            <h1 class="b-profile-user__title">Создание урока</h1>
            <a href="/assets/site/files/OBS-Studio-26.1.1-Full-Installer-x64.exe" class="btn button" download>Скачать  OBS для записи видео</a>
        </div>

        <el-tabs v-model="activeTab"  class="edu-tabs">
            <el-tab-pane label="Урок" name="description">
                <lesson-form :lesson="lesson" :errors="errors"></lesson-form>
                <div class="text-center mb-3">
                    <el-button  type="primary" @click.prevent="store(0)"  style="text-transform: uppercase">
                        Сохранить как черновик
                    </el-button>
                    <el-button type="success" @click.prevent="store(1)"  style="text-transform: uppercase">
                        Опубликовать
                    </el-button>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Тест к уроку" name="test">
                <test-form
                    :data = "testData"
                    ref="create_test"
                    @submitForm="checkTest"
                >
                </test-form>
            </el-tab-pane>
        </el-tabs>


        <div class="overlay" v-if="isLoading">
            <div class="overlay__inner">
                <div class="overlay__content"><span class="spinner"></span></div>
            </div>
        </div>
    </section>
</template>
<script>
import TestForm from "./components/LessonTest/TestForm";
import LessonForm from "./components/lessonForm";
import { Errors } from  '@/common/js/services/errors.js';
    export default {
    components: {
        LessonForm, TestForm
    },
        props:{
            slug:String,
        },
        data() {
            return {
                isLoading:false,
                activeTab:'description',
                course: {},
                active:0,
                min_price:250,
                without_test:false,
                loaded:false,
                lesson: {
                    course_id:null,
                    title:null,
                    price:null,
                    time:null,
                    text:"",
                    type_text:false,
                    type_image:false,
                    type_video:false,
                    type_audio:false,
                    vk_url: ""
                },
                testData:{
                    repeat_period:0,
                    complete_percent:0,
                    questions:[]
                },
                test_state:false,
                errors: new Errors(),
            }
        },
        methods: {
            checkTest(val){
                this.test_state = val
            },
            store(status) {
                this.$refs.create_test.submitForm('data');
                if(!this.test_state){
                    return;
                }
                if(this.testData.questions.length === 0 && !this.without_test){
                    this.$confirm('Вы уверенны в том что хотите создать урок без теста?', 'Тест не создан!', {
                        confirmButtonText: 'Да',
                        cancelButtonText: 'Нет',
                        type: 'warning'
                    }).then(() => {
                        this.without_test = true;
                        this.store(status);
                    }).catch(() => {

                    });
                    return;
                }
                var lesson = this.lesson;
                var testData = this.testData;
                var formData = {};
                var status_item = {status: status};

                Object.assign(formData,lesson, testData, status_item);
                this.isLoading = true;
                axios.post('/api/profile/lesson/store',formData)
                    .then( (response) => {
                        window.location = response.request.responseURL;
                    })
                    .catch( (error) => {
                        this.isLoading = false;
                        this.errors.record(error.response.data.errors);
                    });
            },
            getCourseData() {
                axios.get('/api/profile/course/' + this.slug + '/show')
                    .then ((response) => {
                        this.course = response.data;
                        this.lesson.course_id = response.data.id;
                        this.loaded = true;
                    })
            },
            nextStep(){
                if (this.active === 0){
                    this.$refs.description.submit('lesson');
                }
                else if(this.active === 1){
                    this.$refs.createContent.submit('data');
                }
            },
            submitStep(state){

                if (state){
                    this.next();
                }

            },
            prev() {
                this.active--;
            },
            next() {
                if (this.active++ > 2) this.active = 0;
            },

        },
        mounted() {
            this.getCourseData();
        }
    }
</script>
