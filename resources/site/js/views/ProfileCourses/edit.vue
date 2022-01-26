<template>
    <section>
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a href="/profile" class="breadcrumb__link">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                <a href="/profile/my-courses/active" class="breadcrumb__link">Мои курсы</a>
            </li>
            <li class="breadcrumb__item">
                {{course.title}}
            </li>
        </ul>
        <course-form :form="course" :action-url="actionUrl" v-if="loaded"></course-form>
    </section>
</template>
<script>
import CourseForm from './components/form'
    export default {
    components: {
        CourseForm
    },
        props:['slug'],
        data() {
            return {
                actionUrl: '/api/profile/course/update',
                course: {},
                loaded:false,
            }
        },
        methods: {
            getData() {
                axios.get('/api/profile/course/' + this.slug + '/show')
                .then ((response) => {
                    this.course = response.data;
                    this.loaded = true;
                })
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>
