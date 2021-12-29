<template>
    <section class="lesson-create">
        <div class="b-breadcrumbs">
            <div class="b-breadcrumbs__item">
                <a href="/">Главная</a> / <a href="/profile">Профиль</a> / <a href="/profile/my-courses/active">Мои курсы</a> / {{course.title}}
            </div>
        </div>
        <section class="course-item">
            <div class="course-item__heading">
                <h1 class="course-item__title">
                    {{course.title}}
                </h1>
            </div>
            <div class="course-item__content">
                <figure class="course-item__img">
                    <img :src="course.image" >
                </figure>
                <div class="course-item__main">
                    <p class="course-item__descr">
                        {{course.description}}
                    </p>
                </div>
                <div class="course-item__right">
                    <div class="course-item__price">
                        {{course.price}} ₽
                    </div>
                    <div class="course-item__actions">
                        <div class="mb-2">
                            <el-button icon="el-icon-edit" type="primary" style="width: 100%" @click="handleEdit">Редактировать</el-button>
                        </div>
                        <div class="mb-2">
                            <el-button icon="el-icon-delete" type="danger" style="width: 100%">Удалить</el-button>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <lessons :course_lessons="course.lessons"
                 :course_slug="course.slug"
                 v-if="loaded"></lessons>
    </section>
</template>
<script>
    import lessons from './lessons/index'
    export default {
       props:['slug'],
        components: {
           lessons,
        },
        data() {
           return {
               course: {},
                loaded:false,

           }
        },
        methods: {
            getData() {
                axios.get('/api/profile/course/' + this.slug + '/show')
                    .then ((response) => {
                        this.course = response.data;
                        this.loaded = true;
                    })
            },
            handleEdit() {
                window.location.href = '/profile/course/' + this.course.slug + '/edit';
            }
        },
        mounted() {
           this.getData();
        }
    }


</script>
