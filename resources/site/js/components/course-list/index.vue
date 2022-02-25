<template>
    <section class="course-list" v-if="(courses.length > 0) ">
        <CourseItem
            v-for="(course, index) in courses"
            :key="course.id"
            :course="course"
        ></CourseItem>
    </section>
    <el-alert
        v-else
        :closable="false"
        title="По данному запросу курсы не найдены"
        type="info">
    </el-alert>
</template>
<script>
import EventBus from "../../EventBus";
import CourseItem from "./item";
    export default {
        components: {
            CourseItem,
        },
        props:{

        },
        data() {
            return {
                courses: [],
                loaded:false,
            }
        },
        methods: {
            getCourses(data) {
                this.courses = data;
            },

        },
        created() {
            EventBus.$on('get-filtered-courses', this.getCourses)
        },
        async mounted() {
        }
    }
</script>
