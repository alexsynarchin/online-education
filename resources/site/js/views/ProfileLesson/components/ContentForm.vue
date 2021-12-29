<template>
    <fieldset class="create-lesson__content mt-4">

        <el-form :model="data" ref="data" :rules="rules" label-position="top">
            <el-form-item prop="text" label="Содержимое урока">
                <textarea id="lesson_content"  v-model="data.text" style="width: 100%"></textarea>
            </el-form-item>
            <el-row type="flex" :gutter="10" style="margin-left: 1rem; margin-bottom: 0">

                <el-form-item style="margin-bottom: 0">
                    <el-checkbox v-model="data.type_text">Текст</el-checkbox>
                </el-form-item>

                <el-form-item style="margin-left: 2rem; margin-bottom: 0">
                    <el-checkbox v-model="data.type_image">Изображение</el-checkbox>
                </el-form-item>

                <el-form-item style="margin-left: 2rem; margin-bottom: 0">
                    <el-checkbox v-model="data.type_video">Видео</el-checkbox>
                </el-form-item>
            </el-row>
        </el-form>
    </fieldset>
</template>
<script>

    export default {
        props:['data'],
        data(){
            return{
                rules:{
                    text:[
                        { required: true, message: 'Заполните содержимое урока', trigger: 'blur' },
                    ]
                }
            }
        },
        methods:{
            submit(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('submitStep',true)
                    } else {
                        this.$emit('submitStep',false);
                        return false;
                    }
                });
            },
        },
        mounted() {


        }
    }

</script>
