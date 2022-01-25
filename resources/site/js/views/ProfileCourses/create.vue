<template>
    <section class="lesson-create">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a href="/profile" class="breadcrumb__link">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                Новый Курс
            </li>
        </ul>
        <h1 class="b-profile-user__title">Создание курса</h1>
        <course-form
            :form="form"
            :action-url="actionUrl"
        ></course-form>
    </section>
</template>
<script>

import CourseForm from "./components/form";

export default {
    components: {
        CourseForm
    },
    props: {

    },
    data() {
        return {
            actionUrl: '/api/profile/course/store',
            form: {
                title: "",
                description:"",
                image:"",
                edu_type_id:null,
                edu_level_id:null,
                subject_id:null,
                direction_id:null,
                specialty_id:null,
                yege:false,
                themes: [],
            }
        }
    },

}
</script>
