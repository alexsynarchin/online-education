<template>
    <section>
        <div class="b-breadcrumbs">
            <div class="b-breadcrumbs__item">
                <a href="/">Главная</a> / <a href="/profile">Профиль</a> / <a href="/profile/my-courses/active">Мои курсы</a> / {{course.title}}
            </div>
        </div>
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
