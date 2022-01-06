import Vue from "vue";
import VueRouter from 'vue-router';
import AdminHome from './views/home/index';
import CourseItem from './views/home/show';
import AdminStudents from './views/student/index';
import CategoryType from './views/categories/index';
import AdminTeachers from './views/teacher/index'
Vue.use(VueRouter);
let routes = [
    { name: 'home', path: '/admin', component: AdminHome},
    { name: 'course-item', path: '/admin/courses/:id', component: CourseItem, props: true},
    { name: 'category-types', path: '/admin/categories', component: CategoryType},
    { name: 'students', path: '/admin/students', component: AdminStudents},
    { name: 'teachers', path: '/admin/teachers', component: AdminTeachers},
];
export default new VueRouter({
    mode: 'history',
    routes
});
