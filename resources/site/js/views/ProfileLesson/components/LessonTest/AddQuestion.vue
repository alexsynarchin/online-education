<template>
    <section class="container">
        <h4>Вопрос к тесту</h4>
        <el-form label-position="top" :model="question" ref="question" :rules="rules">
            <el-row type="flex" :gutter="15">
                <el-form-item prop="preview" label="Изображение обложки">
                    <el-upload
                        action=""
                        v-model="question.preview"
                        class="avatar-uploader"
                        :auto-upload="false"
                        :show-file-list="false"
                        :on-change="onFileChange"
                    >
                        <img v-if="question.preview" :src="question.preview" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item  label="Текст вопроса" prop="text" style="flex:  auto; margin-left: 1rem">
                    <richtext v-model="question.text"></richtext>
                </el-form-item>

            </el-row>
        </el-form>
        <div class="divider"></div>
        <h4>Варинты ответа к вопросу </h4>
        <el-button type="primary" icon="el-icon-plus" class="mt-3 mb-2" v-show="!newOptionForm && (question.options.length > 0)" @click.prevent = "newOptionForm=true">Добавить новый вариант ответа</el-button>
        <div class="card mt-4" v-show="newOptionForm || (question.options.length == 0)">
            <el-form :model="newOption" ref="newOption" :rules="rules" label-position="top" class="card-body">
                <el-row type="flex" class="align-items-center ">
                    <el-form-item prop="right_answer" style="margin-bottom: 0">
                        <el-checkbox style="margin-bottom: 0" v-model="newOption.right_answer" label="Это правильный ответ?" border></el-checkbox>
                    </el-form-item>
                    <el-button icon="el-icon-plus" type="primary" style="margin-left: auto"  class="button button--default" @click.prevent="addNewOption('newOption')">Добавить вариант ответа</el-button>
                </el-row>
                <el-row type="flex" :gutter="15">
                    <el-form-item prop="image" label="Картинка к ответу">
                        <el-upload
                            action=""
                            v-model="newOption.preview"
                            class="avatar-uploader"
                            :auto-upload="false"
                            :show-file-list="false"
                            :on-change="onFileOptionChange"
                        >
                            <img v-if="newOption.preview" :src="newOption.preview" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                <el-form-item label="Текст ответа" prop="text" style="flex:  auto; margin-left: 1rem">
                    <richtext  v-model="newOption.text"></richtext>
                </el-form-item>
                </el-row>
            </el-form>
        </div>
        <fieldset v-show="!newOptionForm && (question.options.length > 0)">
            <section
                v-for="(item, index) in question.options"
                class="question-option__wrap list-group mb-4" >
                <Option
                    :option_data="item"
                    :index="index"
                    @update="optionState"
                    v-on:remove="question.options.splice(index, 1)"
                    @writeDeleted="writeDeletedId"
                    ref="options"
                ></Option>
            </section>
            <div class="question__btns mb-3 mt-3 text-center">
                <el-button v-if="editing" type="success" @click.prevent="updateQuestion('question')">Обновить</el-button>
                <el-button v-else type="success" @click.prevent="addQuestion('question')">Опубликовать</el-button>
            </div>
        </fieldset>
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
            onFileChange(file) {
                let cond = this.beforeImageUpload(file.raw);
                console.log(cond);
                if(cond){
                    this.createImage(file);
                }
            },
            onFileOptionChange(file) {
                let cond = this.beforeImageUpload(file.raw);
                console.log(cond);
                if(cond){
                    this.createOptionImage(file);
                }
            },
            beforeImageUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isPNG = file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG && !isPNG) {
                    this.$message.error('Картинка должна быть в формате jpeg или png');
                }
                if (!isLt2M) {
                    this.$message.error('Размер не может превышать 2МБ');
                }
                return (isJPG || isPNG) && isLt2M;
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.question.preview = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
            createOptionImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.newOption.preview = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
            addNewOption:function(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.question.options.push({
                            text: this.newOption.text,
                            preview:this.newOption.preview,
                            right_answer: this.newOption.right_answer
                        });
                        this.newOption.text = '';
                        this.newOption.right_answer = false;
                        this.newOption.preview = '';
                        this.newOptionForm = false;
                    } else {
                        return false;
                    }
                });

            }
        }

    }
</script>
