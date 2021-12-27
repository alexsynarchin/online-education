require('./bootstrap');
import Vue from "vue";

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);
import lang from 'element-ui/lib/locale/lang/ru-RU'
import locale from 'element-ui/lib/locale'
locale.use(lang);
import modal from 'vue-js-modal';
Vue.use(modal);

//Auth

Vue.component('HeaderLogin',require('./components/header/HeaderLogInOrReg.vue').default);
Vue.component('ModalLogin',require('./components/auth/AuthModal.vue').default);

import router from './router'

Vue.component('ProfileDashboard', require('./components/profile-dashboard/index').default);
const app = new Vue({
    el: '#app',
    router,
    created(){
        this.loadedApp();
    },
    data: {
        isLoading: true,

    },
    methods:{
        async loadedApp(){
            this.isLoading = false;
        },

    }
});
