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
    </section>
</template>
<script>
    export default {
        data() {
            return {
                tests:[],
            }
        },
        methods: {
            getTests() {
                axios.get('/api/profile/tests')
                .then((response) => {
                    console.log(response.data);
                })
            },
        },
         mounted() {
            this.getTests();
         }
    }
</script>
