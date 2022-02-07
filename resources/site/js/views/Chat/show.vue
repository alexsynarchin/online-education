<template>
    <section v-if="loaded">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile/messages"> Мои сообщения</a>
            </li>
            <li class="breadcrumb__item">
                Обсуждение урока {{lesson.title}}
            </li>
        </ul>
        <h1 class="page-title">Мои сообщения</h1>

        <student-chat-show :chat="chat"></student-chat-show>
    </section>
</template>
<script>
import StudentChatShow from "../StudentChat/show";
export default {
    props: {
        id:{
           required:true
        },
    },
    data() {
        return {
            loaded:false,
            chat:{},
            lesson: {},
        }
    },
    components: {
        StudentChatShow
    },
    methods: {
        getData() {
            axios.get('/api/profile/chats/' + this.id)
            .then((response) => {
                this.chat = response.data.chat;
                this.lesson = response.data.lesson;
                this.loaded = true;
            })
        },
    },
    mounted() {
        this.getData();
    }
}
</script>
