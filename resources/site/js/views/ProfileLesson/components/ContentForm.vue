<template>
    <fieldset class="create-lesson__content mt-4">
        <el-form :model="ContentData" ref="data" :rules="rules" label-position="top">
            <el-form-item prop="text" label="Содержимое урока">
                <richtext v-model="ContentData.text"></richtext>
            </el-form-item>
            <el-form-item :inline="true"  style="margin-left: 1rem; margin-bottom: 22px" prop="content_type" :error="errors.get('content_type')">
                <el-checkbox v-model="ContentData.type_text">Текст</el-checkbox>
                <el-checkbox v-model="ContentData.type_image">Изображение</el-checkbox>
                <el-checkbox v-model="ContentData.type_audio">Аудио</el-checkbox>
                <el-checkbox v-model="ContentData.type_video">Видео</el-checkbox>
            </el-form-item>
        </el-form>
    </fieldset>
</template>
<script>
import richtext from '@/common/js/components/richtext/index';
    export default {
        props:['ContentData', 'errors'],
        components:{
            richtext,
        },
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
