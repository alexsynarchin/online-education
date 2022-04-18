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
              Результаты тестов
            </li>
        </ul>
        <h1 class="b-profile-user__title">Мои Тесты</h1>
        <section class="course-item"  v-for="(lesson, index) in lessons">
            <h4 class="profile-test-result__title">
                Тест к уроку "{{lesson.title}}"
            </h4>
            <a :href="'/catalog/' + lesson.course.edu_type.slug + '/' + lesson.course.slug + '/' + lesson.slug" class="profile-test-result__link">
                Смотреть результат
            </a>
        </section>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                lessons:[],
            }
        },
        methods: {
            getTests() {
                axios.get('/api/profile/tests')
                .then((response) => {
                   this.lessons = response.data;
                })
            },
        },
         mounted() {
            this.getTests();
         }
    }
</script>
