require('./bootstrap');
import Vue from "vue";
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);
import lang from 'element-ui/lib/locale/lang/ru-RU';
import locale from 'element-ui/lib/locale';
locale.use(lang);

export const eventBus = new Vue();
//Auth
Vue.component('HeaderLogin',require('./components/header/HeaderLogInOrReg.vue').default);
Vue.component('HeaderNavigation', require('./components/header/HeaderNavigation').default);
Vue.component('ModalLogin',require('./components/auth/AuthModal.vue').default);
Vue.component('HeaderMobile', require('./components/header/HeaderMobile').default);
//Buying
Vue.component('BuyBtn',require('./components/buying/button').default);
Vue.component('BuyModal', require('./components/buying/BuyModal').default);
//Header Search
Vue.component('HeaderSearch', require('./components/header/Search').default);
//Footer
Vue.component('FooterLine',require('./components/footer/FooterLine').default);
Vue.component('FooterLinks',require('./components/footer/FooterLinks').default);
Vue.component('FooterLogo',require('./components/footer/FooterLogo').default);
Vue.component('FooterMenu',require('./components/footer/FooterMenu').default);
Vue.component('FooterSocial',require('./components/footer/FooterSocial').default);
//Home
Vue.component('HomeSlider',require('./components/Home/Slider/HomeSlider').default);
Vue.component('HomeBanners',require('./components/Home/banners/index').default);
Vue.component('HomeHowToUseSite',require('./components/Home/HomeHowUseSite').default);
Vue.component('HomeBanner',require('./components/Home/HomeBanner').default);
Vue.component('HomePlus',require('./components/Home/HomePluse').default);
Vue.component('HomeStudyItems',require('./components/Home/HomeStudyItems').default);
Vue.component('HomeVideo', require('./components/Home/VideoHome').default)
Vue.component('FilterSidebar',require('./components/sidebar/index').default);

Vue.component('Comments',require('./components/comment/index').default);

//FAQ
Vue.component('Faq', require('./components/page/QuestationAndAnswers/TheQuestationAndAnswers').default);

//Teacher search
Vue.component('SearchTeachers',require('./components/teacher/index').default);

Vue.component('CourseList', require('./components/course-list/index').default);

//Lesson Student
Vue.component('LessonStudent', require('./components/LessonStudent/index').default);

//Course Rating
Vue.component('CourseRating', require('./components/course-rating').default);
Vue.component('LessonTest', require('./components/lessont-test/index').default);
Vue.component('SendMsg', require('./components/LessonStudent/message').default);

import router from './router'

Vue.component('ProfileDashboard', require('./views/profile-dashboard/index').default);
const app = new Vue({
    el: '#app',
    router,
    created(){
        this.loadedApp();
    },
    data: {
        isLoading:true,
        filtered:false,

    },
    methods:{
        async loadedApp(){
            this.isLoading = false;
        },

    }
});
