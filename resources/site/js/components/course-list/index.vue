<template>
    <section class="course-list">
        <CourseItem
            v-for="(course, index) in courses"
            :key="course.id"
            :course="course"
        ></CourseItem>
    </section>
</template>
<script>
import EventBus from "../../EventBus";
import CourseItem from "./item";
    export default {
        components: {
            CourseItem,
        },
        data() {
            return {
                courses: []
            }
        },
        methods: {
            getCourses(data) {
                this.courses = data;
            }
        },
        created() {
            EventBus.$on('get-filtered-courses', this.getCourses)
        }
    }
</script>
