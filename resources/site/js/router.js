import Vue from "vue";
import VueRouter from 'vue-router';
import UserProfile from './views/profile/index'
import ProfileCourses from "./views/ProfileCourses";
import CourseCreate from "./views/ProfileCourses/create";
Vue.use(VueRouter);
let routes = [
    { name: 'profile', path: '/profile', component: UserProfile},
    { name: 'courses', path: '/profile/my-courses/:slug', component: ProfileCourses, props: true},
    { name: 'course-create', path: '/profile/course/create', component: CourseCreate,},
];
export default new VueRouter({
    mode: 'history',
    routes
});
