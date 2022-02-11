<template>
    <section class="row">
        <nav-item v-for="(menu, index) in menus" :key="index" :menu="menu"></nav-item>
    </section>
</template>
<script>
import menu from './navigation/menu'
export default {
    components:{
        'navItem':menu
    },
    data() {
        return {
            menus:[
                {
                    title:'Верхняя навигация',
                    position:'header-top',
                    items:[],
                },
                {
                    title:'Навигация в футере',
                    position: 'footer',
                    items:[],
                }
            ],
        }
    },

}
</script>
