<template>
    <fieldset class="create-lesson__test mt-4">
        <el-alert
            title=" Проверьте качество усвоения материала вашими студентами."
            type="info"
            show-icon
            :closable="false"
            class="mb-4"
        >
        </el-alert>
        <el-form :model="data" ref="data" :rules="rules" label-position="top">
            <el-row type="flex">
                <el-col :span="9">
                    <el-form-item  prop="repeat_period" label="Период повторного прохождения, в часах">
                        <el-input-number v-model="data.repeat_period" :step="1" :min="0" :max="12"  step-strictly></el-input-number>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item  prop="complete_percent" label="Процент правильных ответов">
                        <el-input-number v-model="data.complete_percent" :step="10" :min="10" :max="100"  step-strictly></el-input-number>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <el-button icon="el-icon-plus" type="primary" class="button  mb-4" @click.prevent="showQuestionModal">
            Добавить Тест
        </el-button>

        <section class="question-list mb-4" v-if="data.questions.length > 0">
            <h5>Вопросы</h5>
            <el-card class="box-card mb-2" v-for="(question, index) in data.questions"
                     v-bind:key="question.id"
                     v-on:remove="question.splice(index, 1)"
            >
                <div  class="d-flex justify-content-between">
                    <div class="question-item__content">
                        <div v-html="question.text"></div>
                    </div>

                    <div class="question__btns" style="width: 100px">
                        <el-button type="primary"  icon="el-icon-edit" circle  @click.prevent="updateQuestion(index,question)"></el-button>
                        <el-button type="danger" icon="el-icon-delete" circle @click.prevent="removeQuestion(index)"></el-button>
                    </div>
                </div>

            </el-card>
        </section>
        <el-dialog
            title="Новый вопрос"
            :visible.sync="questionModal"
            :fullscreen="true"
            center>
            <add-question :editing="editing" :editQuestion="editQuestion" v-if="questionModal" @close="closeQuestionModal"
                          @update="onUpdateQuestion"
                          @add="addQuestion">
            </add-question>
        </el-dialog>

    </fieldset>
</template>
<script>
    import Question from "./Question";
    import AddQuestion from "./AddQuestion"
    export default{
        components:{
            Question, AddQuestion
        },
        props:['data'],
        mounted(){
            console.log(this.data);
        },
        methods: {
            addQuestion(value) {
                this.data.questions.push(value);
                this.$emit('update');
            },
            showQuestionModal()
            {
                this.questionModal = true;
            },
            closeQuestionModal: function () {
                this.questionModal = false;
            },
            updateQuestion(index,question){
                this.editing = true;
                this.editQuestion = question;

                this.questionModal = true;
            },
            removeQuestion(index){
                this.data.questions.splice(index, 1)
            },
            onUpdateQuestion(question){
                this.editQuestion = question;
                this.editing = false;
                this.$emit('update');
                this.closeQuestionModal();
            },
            submitForm(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('submitForm',true)
                    } else {
                        this.$emit('submitForm',false);
                        return false;
                    }
                });
            }
        },
        data(){
            return {
                questionModal: false,
                editQuestion: {
                    text: '',
                    preview: null,
                    options: []
                },
                editing: false,
                rules:{
                    complete_percent:[
                        { type:'number', min: 10, message: 'Процент правильных ответов не может быть меньше 10%', trigger: 'blur' }
                    ]
                }
            }
        }
    }
</script>
