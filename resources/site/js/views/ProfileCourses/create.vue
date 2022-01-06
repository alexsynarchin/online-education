<template>
    <section class="lesson-create">
        <div class="b-breadcrumbs">
            <div class="b-breadcrumbs__item">
                <a href="/">Главная</a> / <a href="/profile">Профиль</a> /  Новый Курс
            </div>
        </div>
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
                themes: [],
            }
        }
    },

}
</script>
