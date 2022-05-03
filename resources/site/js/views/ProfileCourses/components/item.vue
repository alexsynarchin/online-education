<template>
    <section class="course-item">
        <div class="mb-3">
            <el-tag>{{course.edu_type.title}}</el-tag>
            <el-tag>{{course.subject.title}}</el-tag>
            <el-tag>{{course.level.title}}</el-tag>
        </div>
        <el-alert v-if="course.status  === 3" v-for="(item, index) in course.messages"
                  :key="item.id"
                  :title="item.text"
                  class="mb-4"
                  type="error">
        </el-alert>
        <div class="course-item__heading">
            <h4 class="course-item__title" @click="handleShow">
                {{course.title}}
            </h4>
        </div>
        <div class="course-item__content">
            <figure class="course-item__img">
                <img :src="course.image" >
            </figure>
            <div class="course-item__main">
                <p class="course-item__descr">
                    {{course.description}}
                </p>
                <div class="d-flex align-items-center mb-2" style="margin-top: 40px">
                    <h6 class="mb-0" style="margin-right: 20px">Список уроков:</h6>
                    <el-button icon="el-icon-plus" size="medium" type="success" @click="addLesson">Добавить урок</el-button>
                </div>
                <section v-if="course.lessons.length > 0">
                    <ul class="course-item-lessons" style="margin-top: 0">
                        <li class="course-item-lessons__item course-item-lessons__item--preview" v-for="(lesson, index) in course.lessons">
                            <a :href="'/profile/courses/' + course.slug + '/lesson/' + lesson.slug + '/edit'"
                               class="course-item-lessons__link">
                                {{lesson.title}}
                            </a>
                        </li>
                    </ul>
                </section>

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
                        <el-button icon="el-icon-delete" type="danger" style="width: 100%" @click.prevent="handleRemove">Удалить</el-button>
                    </div>

                </div>

            </div>
        </div>
    </section>
</template>
<script>
    import deleteDialog from "../../../mixins/deleteDialog";
    export default {
        mixins:[deleteDialog],
        data() {
            return {

            }},
        props:{
            course:{
                type:Object,
                required:true,
            }
        },
        methods: {
            addLesson() {
                window.location.href = '/profile/courses/' + this.course.slug + '/lesson-create'
            },
            handleShow() {
                window.location.href = '/profile/courses/' + this.course.slug;
            },
            handleEdit() {
                window.location.href = '/profile/course/' + this.course.slug + '/edit';
            },
            async handleRemove() {
                const result = await this.deleteDialog('Удалить курс. Все связанные уроки будут также удалены.')
                if(result) {
                    axios.post('/api/profile/course/' + this.course.id + '/remove')
                        .then((response) => {
                            this.$emit('remove-course', response.data);
                        })
                }
            }
        }
    }
</script>
