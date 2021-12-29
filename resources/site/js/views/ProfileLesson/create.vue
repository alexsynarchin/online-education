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
        <el-steps :active="active" finish-status="success" process-status="finish" class="step-progressbar mb-3">
            <el-step
                title="Шаг 1"
                description="Основная информация"
            >
            </el-step>
            <el-step
                title="Шаг 2"
                description="Контент урока"
            ></el-step>
            <el-step
                title="Шаг 3"
                description="Тест к уроку"
            ></el-step>
        </el-steps>
        <description-form
            ref="description"
            :lesson="descriptionData"
            @submitStep="submitStep"
            v-if="active === 0"
        ></description-form>

        <div class="text-center mb-3">
            <el-button @click.prevent="prev()" v-if="active > 0" style="text-transform: uppercase">Назад</el-button>
            <el-button type="primary"  @click.prevent="nextStep" v-if="active < 2" style="margin-top: 12px; text-transform: uppercase">Продолжить</el-button>
            <el-button  type="primary" @click.prevent="store(0)" v-if="active === 2" style="text-transform: uppercase">Сохранить как черновик</el-button>
            <el-button type="success" @click.prevent="store(1)" v-if="active === 2" style="text-transform: uppercase">Опубликовать</el-button>
        </div>
        <div class="overlay" v-if="isLoading">
            <div class="overlay__inner">
                <div class="overlay__content"><span class="spinner"></span></div>
            </div>
        </div>
    </section>
</template>
<script>
import DescriptionForm from "./components/form";
import ContentForm from "./components/ContentForm";
    export default {
    components: {
        DescriptionForm, ContentForm,
    },
        props:{
            slug:String,
        },
        data() {
            return {
                isLoading:false,
                course: {},
                active:0,
                min_price:250,
                without_test:false,
                loaded:false,
                descriptionData:{
                    course_id:null,
                    title:null,
                    price:null,
                    time:null,
                },

                contentData:{
                    text:null,
                    type_text:null,
                    type_image:null,
                    type_video:null
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
            getCourseData() {
                axios.get('/api/profile/course/' + this.slug + '/show')
                    .then ((response) => {
                        this.course = response.data;
                        this.descriptionData.course_id = response.data.id;
                        this.loaded = true;
                    })
            },
            nextStep(){
                if (this.active === 0){
                    this.$refs.description.Submit('description');
                }
                else if(this.active === 1){
                    this.$refs.createContent.submitForm('data');
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
