<template>
    <section>
        <div class="b-breadcrumbs">
            <div class="b-breadcrumbs__item">
                <a href="/">Главная</a> / <a href="/profile">Профиль</a> /
                <a href="/profile/my-courses/active">Мои курсы</a> /
                <a :href="'/profile/courses/' + slug">{{course.title}}</a> /
                Новый урок
            </div>
            <h1 class="b-profile-user__title">Создание урока</h1>
        </div>
        <el-tabs v-model="activeTab"  class="edu-tabs">
            <el-tab-pane label="Урок" name="description">
                <lesson-form :lesson="lesson"></lesson-form>
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
                },
                testData:{
                    repeat_period:0,
                    complete_percent:0,
                    questions:[]
                },
                test_state:false
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
                        var errors = error.response;
                        var er_data =  errors.data.errors;
                        this.isLoading = false;
                        if(er_data){

                        }
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
