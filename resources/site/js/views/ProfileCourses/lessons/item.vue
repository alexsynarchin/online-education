<template>
    <section class="course-item">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="course-item__title">
                {{lesson.title}}
            </h4>
            <div class="">
                <el-button icon="el-icon-edit" type="primary" @click="handleEdit">Редактировать</el-button>
                <el-button icon="el-icon-delete" type="danger" @click="handleRemove(lesson.id)">Удалить</el-button>
            </div>
        </div>

    </section>
</template>
<script>
import deleteDialog from "../../../mixins/deleteDialog";
    export default {
        mixins:[deleteDialog],
        props: {
            lesson:{
                type:Object,
                required:true,
            }
        },

        methods: {
            handleEdit() {
              this.$emit('handle-edit', this.lesson.slug);
            },
           async handleRemove(id) {

               const result = await this.deleteDialog('Удалить урок?')
               if(result) {
                   axios.post('/api/profile/lesson/' + id +'/remove')
                   .then((response) => {
                        this.$emit('handle-remove', response.data);
                   })
               }
            }
        }
    }
</script>
