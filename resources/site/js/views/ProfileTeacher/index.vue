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
                Мои Преподаватели
            </li>
        </ul>
        <h1 class="page-title">Мои преподаватели</h1>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3" v-for="(teacher, index) in teachers" v-if="teachers.length > 0">
                <a  :href="'/search-teachers/' + teacher.id" class="teacher-item">
                    <figure class="teacher-item__avatar">
                        <img :src="teacher.avatar">
                    </figure>
                    <h4 class="teacher-item__title">
                        {{teacher.name}} {{teacher.surname}}
                    </h4>

                    <ul class="teacher-item__list">
                        <li class="teacher-item__list-item">
                            Образование:
                            <span v-for="(item, index) in teacher.edu_institutions">
                           {{item.title}}<template v-if="(teacher.edu_institutions.length - 1) != index">,</template>
                           </span>
                        </li>
                    </ul>
                </a>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                teachers: [],
            }
        },
        methods: {
            getTeachers() {
                axios.get('/api/profile/teachers')
                .then((response) => {
                    this.teachers = response.data;
                })
            }
        },
        mounted() {
            this.getTeachers();
        }
    }
</script>
