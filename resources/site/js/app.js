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
const eventBus = new Vue()
//Auth
Vue.component('HeaderLogin',require('./components/header/HeaderLogInOrReg.vue').default);
Vue.component('HeaderNavigation', require('./components/header/HeaderNavigation').default);
Vue.component('ModalLogin',require('./components/auth/AuthModal.vue').default);
//Footer
Vue.component('FooterLine',require('./components/footer/FooterLine').default);
Vue.component('FooterLinks',require('./components/footer/FooterLinks').default);
Vue.component('FooterLogo',require('./components/footer/FooterLogo').default);
Vue.component('FooterMenu',require('./components/footer/FooterMenu').default);
Vue.component('FooterSocial',require('./components/footer/FooterSocial').default);
//Home
Vue.component('HomeSlider',require('./components/Home/Slider/HomeSlider').default);
Vue.component('HomeHowToUseSite',require('./components/Home/HomeHowUseSite').default);
Vue.component('HomeBanner',require('./components/Home/HomeBanner').default);
Vue.component('HomePlus',require('./components/Home/HomePluse').default);
Vue.component('HomeStudyItems',require('./components/Home/HomeStudyItems').default);

Vue.component('FilterSidebar',require('./components/sidebar/index').default);

Vue.component('Comments',require('./components/comment/index').default);

//FAQ
Vue.component('Faq',require('./components/page/QuestationAndAnswers/TheQuestationAndAnswers').default);

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
