import Vue from "vue";
import VueRouter from 'vue-router';
import UserProfile from './views/profile/index'
import ProfileCourses from "./views/ProfileCourses";
//Course teacher
import CourseCreate from "./views/ProfileCourses/create";
import CourseEdit from './views/ProfileCourses/edit';
import CourseShow from './views/ProfileCourses/show';
import LessonCreate from './views/ProfileLesson/create';
Vue.use(VueRouter);
let routes = [
    { name: 'profile', path: '/profile', component: UserProfile},
    { name: 'courses', path: '/profile/my-courses/:slug', component: ProfileCourses, props: true},
    { name: 'course.create', path: '/profile/course/create', component: CourseCreate},
    { name: 'course.edit', path: '/profile/course/:slug/edit', component: CourseEdit, props: true},
    {name: 'course.show', path: '/profile/courses/:slug', component: CourseShow, props: true},
    {name: 'lesson.create', path: '/profile/courses/:slug/lesson-create', component: LessonCreate, props: true},

];
export default new VueRouter({
    mode: 'history',
    routes
});
