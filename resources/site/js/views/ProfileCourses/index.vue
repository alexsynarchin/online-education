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
        <div class="row align-items-center">
            <div class="col-md-9">
                <h1 class="b-profile-user__title">Мои курсы</h1>
            </div>
            <div class="col-md-3">
                <a class="button button--w-100" href="/profile/course/create">
                    Создать Курс
                </a>
            </div>
        </div>

        <ul class="nav b-tab">
            <li class="nav-item b-tab__title" v-for="(tab, index) in tabs">
                <a :href="'/profile/my-courses/' + tab.type"  class="nav-link b-tab__link" :class="{'active': tab.type === active_tab}">
                    {{tab.title}}
                </a>
            </li>
        </ul>
        <div class="mt-4 mb-4">
            <course-item v-for="(course, index) in courses"
                         :key="course.id"
                         :course="course"
                         @remove-course="removeCourse"
            >
            </course-item>
        </div>
    </section>
</template>
<script>
import CourseItem from './components/item'
    export default {
    components: {
        CourseItem,
    },
        props:{
            user: {
                type:Object,
                required:true,
            },
        },
        data() {
            return {
                courses: [],
                active_tab:'active',
                tabs:[
                    {
                        type:'active',
                        title: "Активные"
                    },
                    {
                        type:'moderate',
                        title: "На модерации"
                    },
                    {
                        type:'draft',
                        title: "Черновики"
                    },
                    {
                        type:'cancel',
                        title: "Отклоненные"
                    },
                ],
            }
        },
        methods: {
            getCourses() {
                axios.get('/api/profile/course/index/' + this.active_tab)
                .then((response) => {
                    this.courses = response.data;
                })
            },
            removeCourse(id) {
                let index = this.courses.findIndex(x => x.id === id);
                this.courses.splice(index, 1);
            },
        },
        mounted() {
            this.active_tab = this.$route.params.slug;
            this.getCourses();
        }
    }
</script>
