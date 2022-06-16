<template>
    <fieldset class="create-lesson__content mt-4">
        <div class="mb-3">
            <el-button type="primary" @click="dialogVisible = true" v-if="!data.vk_url">Добавить видео из вконтакте</el-button>
            <el-button type="danger" @click="deleteVkVideo" v-if="data.vk_url">Удалить видео</el-button>
            <div  v-if="data.vk_url" class="mt-3">
                <iframe
                    :src="data.vk_url" width="100%" height="480"
                    allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" frameborder="0" allowfullscreen
                ></iframe>
            </div>

        </div>
        <el-form :model="data" ref="data" :rules="rules" label-position="top">
            <el-form-item prop="text" label="Содержимое урока">
                <richtext v-model="data.text"></richtext>
            </el-form-item>
            <el-form-item :inline="true"  style="margin-left: 1rem; margin-bottom: 22px" prop="content_type" :error="errors.get('content_type')">
                <el-checkbox v-model="data.type_text">Текст</el-checkbox>
                <el-checkbox v-model="data.type_image">Изображение</el-checkbox>
                <el-checkbox v-model="data.type_audio">Аудио</el-checkbox>
                <el-checkbox v-model="data.type_video">Видео</el-checkbox>
            </el-form-item>
        </el-form>
        <el-dialog
            append-to-body
            v-if="dialogVisible"
            title="Вставьте код видео"
            :visible.sync="dialogVisible"
            width="40%">
            <el-input
                type="textarea"
                :rows="5"
                placeholder="Вставьте код видео"
                v-model="vkFrame">
            </el-input>
            <div id="iframe_container" style="display: none" v-html="vkFrame">
            </div>
            <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="getVkUrl">Добавить видео</el-button>
           <el-button @click="dialogVisible = false">Отмена</el-button>
  </span>
        </el-dialog>
    </fieldset>
</template>
<script>
import richtext from '@/common/js/components/richtext/index';
    export default {
        props:['data', 'errors'],
        components:{
            richtext,
        },
        data(){
            return{
                dialogVisible:false,
                vkFrame:"",
                rules:{
                    text:[
                        { required: true, message: 'Заполните содержимое урока', trigger: 'blur' },
                    ]
                }
            }
        },
        methods:{
            deleteVkVideo() {
                this.data.vk_url = "";
            },
            getVkUrl() {
                let url =document.getElementById("iframe_container");
                url = url.getElementsByTagName('iframe');
                if(url.length > 0){

                    url = url[0];
                    url = url.getAttribute('src');
                }
                this.data.vk_url = url;
                this.dialogVisible =false;
            },
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
