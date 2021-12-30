<template>
    <section class="lessons-list">
        <lesson-item @handle-view="handleView" :index="index" :lesson="lesson" :key="lesson.id" v-for="(lesson, index) in lessons"></lesson-item>
        <el-dialog
            :visible.sync="dialogVisible"
            width="80%"
            center>
            <lesson-show :id="lesson_id" v-if="dialogVisible" @change-status="changeStatus"></lesson-show>
            <span slot="footer" class="dialog-footer">
            <el-button @click="dialogVisible = false">Закрыть</el-button>
  </span>
        </el-dialog>
    </section>
</template>
<script>
import LessonItem from './item';
import LessonShow from './show';
    export default {
        components: {
            LessonItem, LessonShow,
        },
        props: {
            lessons: {
                type:Array,
                required:true,
            }
        },
        data() {
            return {
                dialogVisible:false,
                lesson_id: null,
                lesson_index:null,
            }
        },
        methods: {
            handleView(data) {
                this.lesson_id = data.id;
                this.lesson_index = data.index;
                this.dialogVisible = true;
            },
            changeStatus(status) {
                this.lessons[this.lesson_index].status = status;
            }
        }
    }
</script>
