<template>
    <section>
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                Уведомления
            </li>
        </ul>
        <h1 class="b-profile-user__title">Уведомления</h1>
        <div class="b-table-transac">
            <div class="b-table-transac__body">
                <div class="b-table-transac__item" v-for="(item, index) in notifications" :key="index">
                    <div class="b-table-transac__item_message">{{item.data.type}}</div>
                    <div class="b-table-transac__item_des">{{item.data.text}}</div>
                    <div class="b-table-transac__item_date">{{item.formatted_created_at}}</div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                notifications:[],
            }
        },
        methods: {
            getNotifications() {
                axios.get('/api/profile/notifications')
                .then((response) => {
                    console.log(response.data);
                    this.notifications = response.data;
                })
            },
        },
        mounted() {
            this.getNotifications();
        }
    }
</script>
