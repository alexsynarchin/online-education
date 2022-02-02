import Vue from "vue";
import VueRouter from 'vue-router';
import UserProfile from './views/profile/index'
import ProfileCourses from "./views/ProfileCourses";
import StudentCourses from "./views/StudentCourses";
import ProfileTeacher from "./views/ProfileTeacher";
//Course teacher
import CourseCreate from "./views/ProfileCourses/create";
import CourseEdit from './views/ProfileCourses/edit';
import CourseShow from './views/ProfileCourses/show';
import LessonCreate from './views/ProfileLesson/create';
import LessonEdit from './views/ProfileLesson/edit';

Vue.use(VueRouter);
let routes = [
    { name: 'profile', path: '/profile', component: UserProfile},
    { name: 'courses', path: '/profile/my-courses/:slug', component: ProfileCourses, props: true},
    { name: 'course.create', path: '/profile/course/create', component: CourseCreate},
    { name: 'course.edit', path: '/profile/course/:slug/edit', component: CourseEdit, props: true},
    {name: 'course.show', path: '/profile/courses/:slug', component: CourseShow, props: true},
    {name: 'lesson.create', path: '/profile/courses/:slug/lesson-create', component: LessonCreate, props: true},
    {name: 'lesson.edit', path: '/profile/courses/:slug/lesson/:lesson_slug/edit', component: LessonEdit, props:true},
    {name: 'student-courses.index', path: '/profile/education', component: StudentCourses},
    {name: 'teachers', path: '/profile/teachers', component: ProfileTeacher},
];
export default new VueRouter({
    mode: 'history',
    routes
});
