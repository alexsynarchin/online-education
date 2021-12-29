<template>
    <section class="course-item">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="course-item__title">
                {{lesson.title}}
            </h4>
            <div class="">
                <el-button icon="el-icon-edit" type="primary" @click="handleEdit">Редактировать</el-button>
                <el-button icon="el-icon-delete" type="danger" >Удалить</el-button>
            </div>
        </div>

    </section>
</template>
<script>
    export default {
        props: {
            lesson:{
                type:Object,
                required:true,
            }
        },

        methods: {
            handleEdit() {

            },
        }
    }
</script>
