<template>
    <section>

        <CourseItem

            v-for="(course, index) in courses"
            :key="course.id"
            :course="course"
        ></CourseItem>
    </section>
</template>
<script>
import CourseItem from "../../course-list/item";
    export default {
        components: {
            CourseItem
        },
        props: ['courses']
    }
</script>
