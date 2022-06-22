<template>
    <el-menu
        :router="true"
        class="el-menu-vertical-demo"
    >
    <el-menu-item  v-for="item in menu"  v-bind:key="item.id" :index="item.id" class="el-menu-item__link sidebar-nav__link" v-if="item.check">
            <i class="sidebar-nav__icon" :class="item.icon"></i>
            <span class="sidebar-nav__link-text">
                 {{item.title}}
            </span>
    </el-menu-item>
    </el-menu>
</template>
<script>
export default {
    mounted(){


    },
    props: ['user'],
    computed:{

    },
    data(){
        return{

            menu:[
                {

                    id:"/admin",
                    title:"Курсы",
                    icon:"educate-icon educate-course",
                    check: true,

                },
                {

                    id:"/admin/categories",
                    title:"Категории контента",
                    icon:"educate-icon educate-library",
                    check: true,
                },
                {

                    id:"/admin/locations",
                    title:"Города и учебные заведения",
                    icon:"educate-icon educate-library",
                    check: true,
                },
                {

                    id:"/admin/students",
                    title:"Студенты",
                    icon:"educate-icon educate-student icon-wrap",
                    check: this.user.super_admin
                },
                {

                    id:"/admin/teachers",
                    title:"Преподаватели",
                    icon:"educate-icon educate-professor icon-wrap",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/withdraws",
                    title:"Запросы на вывод средств",
                    icon:"el-icon-coin",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/orders",
                    title:"Заказы",
                    icon:"el-icon-coin",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/moderators",
                    title:"Модераторы",
                    icon:"el-icon-user",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/promo-codes",
                    title:"Промокоды",
                    icon:"el-icon-magic-stick",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/static-pages",
                    title:"Статические страницы",
                    icon:"educate-icon educate-library",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/articles",
                    title:"Блог",
                    icon:"educate-icon educate-library",
                    check: this.user.super_admin
                },
                {
                    id:"/admin/settings",
                    title:"Настройки",
                    icon:"el-icon-setting",
                    check: this.user.super_admin
                },
            ]
        }
    }
}
</script>
