<template>
    <section class="lesson-page" style="max-width: 1160px">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item><a href="/admin">Курсы</a></el-breadcrumb-item>
            <el-breadcrumb-item>{{course.title}}</el-breadcrumb-item>
        </el-breadcrumb>
        <section class="lesson__heading d-flex align-items-center justify-content-between">
            <h1 class="teacher-lesson__title">{{course.title}}</h1>
            <div class="lesson__btns d-flex justify-content-end">
                <el-button type="success" @click.prevent="courseChangeStatus(2)" v-if="course.status != 2">Опубликовать</el-button>
                <el-button type="warning" @click.prevent="courseChangeStatus(1)" v-if="course.status === 2">Снять с публикации</el-button>
                <el-button type="danger" @click.prevent="dialogCancel = true" v-if="course.status === 1">Отклонить</el-button>
            </div>
        </section>
        <el-tabs type="card" >

            <el-tab-pane label="Основная информация">
                <Description :course="course" v-if="course.author"></Description>
            </el-tab-pane>
        </el-tabs>
        <el-dialog title="Отклонить Курс" width="40%" :visible.sync="dialogCancel" >
            <el-form :model="cancelForm" ref="cancelForm" :rules="rules_cancel">
                <el-form-item label="Причина отклонения Курса" prop="text">
                    <el-input
                        type="textarea"
                        :rows="4"
                        placeholder="Введите сообщение"
                        v-model="cancelForm.text">
                    </el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
    <el-button @click="publishCancel('cancelForm')">Отклонить</el-button>
    <el-button type="primary" @click="dialogCancel  = false">Отменить</el-button>
  </span>
        </el-dialog>
    </section>
</template>
<script>
import Description from "./components/Description";
    export default {
        props:['id'],
        components:{
            Description,
        },
        data() {
            return {
                course: {},
                dialogCancel:false,
                cancelForm:{
                    text:""
                },
                rules_cancel:{
                    text:[{required:true,message:'Введите причину отклонения Курса'}]
                }
            }
        },
        methods: {
            getData() {
                axios.get('/api/admin/courses/' + this.id)
                .then((response) => {
                    this.course = response.data;
                })
            },
            publishCancel(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        ///lesson-{id}/cancel-message
                        axios.post('/api/admin/course/'+ this.course.id +'/cancel-message',{message:this.cancelForm.text})
                            .then((response) => {
                                console.log(response.data);
                                this.dialogCancel = false;
                                this.courseChangeStatus(3);
                            })
                            .catch((error) => {

                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            courseChangeStatus(status) {
                axios.post('/api/admin/course/change-status', {id:this.course.id, status:status})
                    .then((response)=>{
                        this.course.status = status;
                        this.$notify({
                            title: 'Отлично',
                            message: response.data,
                            type: 'success',
                            duration:4000
                        });
                    })
                    .catch((error)=>{
                        console.log(error)
                    });
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>
