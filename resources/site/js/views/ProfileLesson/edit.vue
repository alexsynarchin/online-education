<template>
    <section>
        <div class="b-breadcrumbs">
            <div class="b-breadcrumbs__item">
                <a href="/">Главная</a> /
                <a href="/profile">Профиль</a> /
                <a href="/profile/my-courses/active">Мои курсы</a> /
                <a :href="'/profile/courses/' + slug">{{course.title}}</a> /
                {{lesson.title}} : редактирование
            </div>
        </div>
        <h1 class="b-profile-user__title">{{lesson.title}} : редактирование</h1>
        <el-tabs v-model="activeTab"  class="edu-tabs">
            <el-tab-pane label="Основная информация" name="description">
                <description-form :lesson="lesson"></description-form>
            </el-tab-pane>
            <el-tab-pane label="Содержимое урока" name="content">
                <content-form :data="lesson.content" v-if="loaded"></content-form>
            </el-tab-pane>
            <el-tab-pane label="Тест к уроку" name="test">
                <test-form :data="test"   v-if="loaded"></test-form>
            </el-tab-pane>
        </el-tabs>
        <el-button style="margin-right: 2rem"  type="success" @click.prevent="updateLesson">Сохранить</el-button>
        <el-button  type="info" @click.prevent="canselUpdate">Отменить</el-button>
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
                axios.post('/api/profile/lesson/update', {course:this.course, lesson:this.lesson, test:this.test})
                .then((response) => {
                    window.location.href = '/profile/courses/' + this.slug
                })
            },
            getData() {
                axios.get('/api/profile/' + this.slug + '/' + this.lesson_slug + '/show')
                .then((response) => {
                    this.course = response.data.course;
                    this.lesson = response.data.lesson;
                    this.test = response.data.test;
                    this.loaded = true;
                })
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>
