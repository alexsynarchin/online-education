<template>
    <section>
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                Мои курсы
            </li>
        </ul>
        <section  v-if="courses.length > 0">
            <CourseItem

                v-for="(course, index) in courses"
                :key="course.id"
                :course="course"
            ></CourseItem>
        </section>

        <el-alert
            v-else
            :closable="false"
            title="У вас пока нет купленных курсов"
            type="info">
        </el-alert>
    </section>
</template>
<script>
import CourseItem from "../../components/course-list/item";
    export default {
        components: {
            CourseItem,
        },
        data(){
            return {
                courses:[],
            }
        },
        methods: {
            getCourses() {
                axios.get('/api/education')
                .then((response) => {
                    this.courses = response.data;
                })
            },
        },
        mounted() {
            this.getCourses();
        }
    }
</script>
