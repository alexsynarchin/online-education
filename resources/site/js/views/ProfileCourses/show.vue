<template>
    <section class="lesson-create">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a href="/profile" class="breadcrumb__link">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                <a href="/profile/my-courses/active" class="breadcrumb__link">Мои курсы</a>
            </li>
            <li class="breadcrumb__item">
                {{course.title}}
            </li>
        </ul>
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
                            <el-button icon="el-icon-delete" type="danger" style="width: 100%" @click.prevent = handleRemove>Удалить</el-button>
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
    import lessons from './lessons/index';
    import deleteDialog from "../../mixins/deleteDialog";
    export default {
        mixins:[deleteDialog],
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
            },
            async handleRemove() {
                console.log('delete');
                const result = await this.deleteDialog('Удалить курс. Все связанные уроки будут также удалены.')
                if(result) {
                    axios.post('/api/profile/course/' + this.course.id + '/remove')
                        .then((response) => {
                            window.location.href= '/profile/my-courses/moderate'
                        })
                }
            }
        },
        mounted() {
           this.getData();
        }
    }


</script>
