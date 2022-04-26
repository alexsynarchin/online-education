<template>
    <section class="">
        <div class="test-modal__question">
            <h4>Вопрос к тесту</h4>
            <el-form label-position="top" :model="question" ref="question" :rules="rules">
                <el-row type="flex" :gutter="15">
                    <el-form-item  label="Текст вопроса" prop="text" style="flex:  auto; margin-left: 1rem">
                        <richtext v-model="question.text"></richtext>
                    </el-form-item>

                </el-row>
            </el-form>
        </div>
        <div class="divider mb-4"></div>
        <div class="test-modal__answers">
            <h4>Ответы</h4>
            <fieldset v-show="!newOptionForm && (question.options.length > 0)">
                <section
                    v-for="(item, index) in question.options"
                    class="question-option__wrap " >
                    <Option
                        class="list-group"
                        :option_data="item"
                        :index="index"
                        @update="optionState"
                        v-on:remove="question.options.splice(index, 1)"
                        @writeDeleted="writeDeletedId"
                        ref="options"
                    ></Option>
                </section>

            </fieldset>
            <div class="mt-3">
                <el-button type="primary" icon="el-icon-plus" class="mt-3 mb-2"  @click.prevent = "addNewOption">
                    Добавить новый вариант ответа
                </el-button>
            </div>
            <div class="question__btns mb-3 mt-3">
                <el-button v-if="editing" type="success" @click.prevent="updateQuestion('question')">Сохранить тест</el-button>
                <el-button v-else type="success" @click.prevent="addQuestion('question')">Сохранить тест</el-button>
            </div>
        </div>

    </section>
</template>
<script>
    import Option from './Option'
    import richtext from "../../../../../../common/js/components/richtext";
    export default{
        props:['editQuestion','editing'],
        components:{
            Option, richtext
        },
        data(){
            return{
                newOptionForm:false,
                newOption: {
                    text:'',
                    right_answer: false,
                    preview:""
                },
                question:{
                    text:'',
                    preview:null,
                    options:[]
                },
                rules:{
                    text:[
                        {required:true,message:'Текст вопроса не может быть пустым'}
                    ]
                },
                state: false,
                right_check:false,
                deleted_options:[]
            }
        },
        created(){
            this.initData();
        },
        mounted(){
            if(this.question.options.length === 0) {
                this.question.options.push({
                    text: "",
                    preview:"",
                    right_answer: false,
                });
            }
        },
        methods:{
            writeDeletedId(id){

                console.log(id);
            },
            checkRightAnswer(){
                this.right_check = false;
                for (var i = 0; i < this.question.options.length; i++){
                    if(this.question.options[i].right_answer === true){
                        this.right_check = true;
                    }
                }
            },
            checkState(){
                for (var i = 0; i < this.$refs.options.length; i++) {
                    this.$refs.options[i].submitForm('option_data');
                    if(this.state === false){
                        return;
                    }
                }
            },
            initData(){
                if(this.editing){
                    this.question = this.editQuestion;
                }
            },
            optionState(val){
                this.state = val;
            },
            updateQuestion(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.checkRightAnswer();
                        this.checkState();
                        if(!this.right_check){
                            this.$notify.error({
                                title: 'Ошибка',
                                message: 'Хотя бы один вариант ответа должен быть правильным'
                            });
                        }
                        if(this.state && this.right_check){
                            this.$emit('update', this.question);
                        }
                    } else {
                        return false;
                    }
                });
            },
            addQuestion: function(formName){
                var _send_data = this.question;
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.checkRightAnswer();
                        this.checkState();
                        if(!this.right_check){
                            this.$notify.error({
                                title: 'Ошибка',
                                message: 'Хотя бы один вариант ответа должен быть правильным'
                            });
                        }
                        if(this.state && this.right_check){
                            this.$emit('add',_send_data);
                            this.$emit('close');
                        }
                    } else {
                        return false;
                    }
                });


            },

            addNewOption:function(){
                this.question.options.push({
                    text: "",
                    preview:"",
                    right_answer: false,
                });
            }
        }

    }
</script>
