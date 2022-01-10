<template>
    <section class="course-item">
        <div class="course-item__heading">
            <h4 class="course-item__title">
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
            handleEdit() {
                window.location.href = '/profile/courses/' + this.course.slug;
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
