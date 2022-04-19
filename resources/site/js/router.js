import Vue from "vue";
import VueRouter from 'vue-router';
import UserProfile from './views/profile/index'
import ProfileCourses from "./views/ProfileCourses";
import StudentCourses from "./views/StudentCourses";
import ProfileTeacher from "./views/ProfileTeacher";
import Chat from "./views/Chat/index"
import ChatShow from "./views/Chat/show";
import Notifications from "./views/Notification/index";
import StudentTests from "./views/ProfileTest/index";
import MyStudents from "./views/my-students";
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
    {name: 'chat.index', path: '/profile/messages', component:Chat},
    {name: 'chat.show', path: '/profile/messages/:id', component:ChatShow, props: true},
    {name: 'notifications', path:'/profile/notifications', component: Notifications},
    {name: 'test.index', path:'/profile/tests', component: StudentTests},
    {name: 'students',  path:'/profile/students', component: MyStudents}
];
export default new VueRouter({
    mode: 'history',
    routes
});
