<template>
    <section v-if="loaded">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h3 class="course-item__title d-flex align-items-center">
                <span style="margin-right: 10px">{{lesson.title}}</span>
                <status :active_status="lesson.status"></status>
            </h3>
            <div class="lesson__btns d-flex justify-content-end">
                <el-button type="success" @click.prevent="lessonChangeStatus(2)" v-if="lesson.status != 2">Опубликовать</el-button>
                <el-button type="warning" @click.prevent="lessonChangeStatus(1)" v-if="lesson.status === 2">Снять с публикации</el-button>
                <el-button type="danger" @click.prevent="dialogCancel = true" v-if="lesson.status === 1">Отклонить</el-button>
            </div>
        </div>

        <el-tabs type="card" >
            <el-tab-pane label="Основная информация">
                <div class="mb-2">
                    <label>Стоимость урока:</label>
                    <span>{{lesson.price}} руб.</span>
                </div>
                <div class="mb-2">
                    <label>Стоимость урока, предложенная преподавателем:</label>
                    <span>{{lesson.price_user}} руб.</span>
                </div>
                <div class="mb-2">
                    <label style="font-weight: 700; font-size: 17px; margin-bottom: 15px;">Контент урока:</label>
                    <div v-html="lesson.content.text"></div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Тест к уроку">

            </el-tab-pane>
        </el-tabs>
        <el-dialog title="Отклонить Урок" width="40%" :visible.sync="dialogCancel" append-to-body>
            <el-form :model="cancelForm" ref="cancelForm" :rules="rules_cancel">
                <el-form-item label="Причина отклонения урока" prop="text">
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
    export default {
        props: {
          id: {
              type:Number,
              required:true,
          }
        },
        data() {
            return {
                lesson: {},
                loaded:false,
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
                axios.get('/api/admin/lesson/show/' + this.id)
                .then((response) => {
                    this.lesson = response.data;
                    this.loaded = true;
                })
            },
            lessonChangeStatus(status) {
                axios.post('/api/admin/lesson/change-status', {id:this.lesson.id, status:status})
                    .then((response)=>{
                        this.lesson.status = status;
                        this.$emit('change-status',status);
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
            publishCancel(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {

                        ///lesson-{id}/cancel-message
                        axios.post('/api/admin/lesson/'+ this.lesson.id +'/cancel-message',{message:this.cancelForm.text})
                            .then((response) => {
                                console.log(response.data);
                                this.dialogCancel = false;
                                this.lessonChangeStatus(3);
                            })
                            .catch((error) => {

                            });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
        },
        mounted() {
            this.getData();
        }
    }
</script>
