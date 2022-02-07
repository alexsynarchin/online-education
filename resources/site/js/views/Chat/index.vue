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
                Мои сообщения
            </li>
        </ul>
        <h1 class="page-title">Мои сообщения</h1>
        <student-chat></student-chat>
    </section>
</template>
<script>
import StudentChat from "../StudentChat/index";
    export default {
        components: {
            StudentChat
        }
    }
</script>
