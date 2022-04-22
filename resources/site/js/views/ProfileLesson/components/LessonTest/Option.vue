<template>
    <el-form class="question-option mt-3 list-group-item" :rules="rules" label-position="top" :model="option_data" ref="option_data">
                <el-row type="flex" class="align-items-center">
                    <h6 style="margin-bottom: 0"> Вариант ответа {{index + 1}}</h6>
                    <el-form-item prop="right_answer" style="margin-left:1rem; margin-bottom: 0">
                        <el-checkbox  style="margin-bottom: 0" v-model="option_data.right_answer" label="Правильный ответ?" border></el-checkbox>
                    </el-form-item>
                    <el-button style="margin-left: auto" icon="el-icon-delete" circle type="danger" v-on:click.prevent="removeOption"></el-button>
                </el-row>
        <el-row type="flex" :gutter="15">
                <el-form-item label="Текст ответа" prop="text" style="flex:  auto; margin-left: 1rem">
                    <richtext  v-model="option_data.text"></richtext>
                </el-form-item>
        </el-row>
    </el-form>
</template>
<script>
    import richtext from "../../../../../../common/js/components/richtext";
    export default {
        components: {
            richtext,
        },
        props:['option_data','index'],
        data(){
            return{
                rules:{
                    text:[
                        {required:true,message:'Текст ответа не может быть пустым'}
                    ]
                }
            }
        },
        methods:{
            submitForm(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('update', true);
                    } else {
                        this.$emit('update', false);
                        return false;
                    }
                });
            },
            removeOption(){
                let id = ('id' in this.option_data) ? this.option_data.id : false;
                this.$emit('writeDeleted', id);
                this.$emit('remove');
            },
            onFileChange(file) {
                let cond = this.beforeImageUpload(file.raw);
                console.log(cond);
                if(cond){
                    this.createImage(file);
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
                    vm.option_data.preview = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
        },

        mounted() {

        },

    }
</script>
