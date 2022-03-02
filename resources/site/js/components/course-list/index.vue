<template>
    <section class="course-list" v-if="(courses.length > 0) ">
        <section class="course-list-sort">
            <label class="course-list-sort__label">
                Сортировать по:
            </label>
            <span class="course-list-sort__item" v-for="(item, index) in SortList">
                {{item.title}}
            </span>
        </section>
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
                SortList: [
                    {
                        title:'Рейтингу',
                        value:'rating',
                        direction:'ASC',
                    },
                    {
                        title:'Новизне',
                        value:'created_at',
                        direction:'ASC',
                    },
                    {
                        title:'Цене',
                        value:'price',
                        direction:'ASC',
                    },

                ],
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
