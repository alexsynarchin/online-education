<template>
    <section>
        <h1 class="page-title">{{course.title}}</h1>
        <course-form :form="course" :action-url="actionUrl" v-if="loaded"></course-form>
    </section>
</template>
<script>
import CourseForm from './components/form'
    export default {
    components:{CourseForm},
        props:['slug'],
        data() {
            return {
                actionUrl: '/api/profile/course/update',
                course: {},
                loaded: false,
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
