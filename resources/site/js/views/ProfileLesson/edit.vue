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
        <el-tabs v-model="activeTab"  class="edu-tabs">
            <el-tab-pane label="Урок" name="description">
                <description-form :lesson="lesson"></description-form>
                <content-form
                    :ContentData ="contentData"
                    v-if="loaded"></content-form>
                <el-button style="margin-right: 2rem"  type="success" @click.prevent="updateLesson">Сохранить</el-button>
                <el-button  type="info" @click.prevent="canselUpdate">Отменить</el-button>
            </el-tab-pane>
            <el-tab-pane label="Тест к уроку" name="test">
                <test-form :data="test"  @update="updateTest"  v-if="loaded"></test-form>
            </el-tab-pane>
        </el-tabs>

    </section>
</template>
<script>
    import DescriptionForm from "./components/form";
    import ContentForm from "./components/ContentForm";
    import TestForm from "./components/LessonTest/TestForm";
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
            }
        },
        methods: {
            canselUpdate() {
                window.location.href = '/profile/courses/' + this.slug
            },
            updateLesson() {
                axios.post('/api/profile/lesson/update', {course:this.course, lesson:this.lesson, test:this.test, contentData:this.contentData, updateTest:false})
                .then((response) => {
                    window.location.href = '/profile/courses/' + this.slug
                })
            },
            getData() {
                axios.get('/api/profile/' + this.slug + '/' + this.lesson_slug + '/show')
                .then((response) => {
                    this.course = response.data.course;
                    this.lesson = response.data.lesson;
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
