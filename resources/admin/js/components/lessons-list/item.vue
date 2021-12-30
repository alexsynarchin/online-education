<template>
    <section class="course-item d-flex align-items-center justify-content-between">
        <h4 class="course-item__title d-flex align-items-center ">
           <span style="margin-right: 10px;">{{lesson.title}}</span>  <status :active_status="lesson.status"></status>
        </h4>
        <el-button icon="el-icon-edit" type="primary" @click="handleView">Просмотр</el-button>
    </section>
</template>
<script>
    export default {
        props: {
            lesson: {
                type:Object,
                required:true
            },
            index: {
                type:Number,
                required: true,
            }
        },
        methods: {
            handleView() {
                this.$emit('handle-view', {id: this.lesson.id, index: this.index});
            }
        }
    }
</script>
