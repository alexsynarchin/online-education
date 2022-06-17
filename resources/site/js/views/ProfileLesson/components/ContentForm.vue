<template>
    <fieldset class="create-lesson__content mt-4">
        <el-form :model="ContentData" ref="data" :rules="rules" label-position="top">
            <label for="text" class="el-form-item__label">Содержимое урока</label>
            <div class="mb-2">
                <el-button type="primary" @click="dialogVisible = true" v-if="!ContentData.vk_url && !ContentData.youtube_url">Добавить видео</el-button>
                <el-button type="danger" @click="deleteVkVideo" v-if="ContentData.vk_url || ContentData.youtube_url">Удалить видео</el-button>
                <div  v-if="ContentData.vk_url" class="mt-3">
                    <iframe
                        :src="ContentData.vk_url" width="100%" height="480"
                        allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" frameborder="0" allowfullscreen
                    ></iframe>
                </div>
                <div  v-if="ContentData.youtube_url" class="mt-3">
                    <iframe width="100%" height="480" :src="ContentData.youtube_url" frameborder="0" allowfullscreen></iframe>
                </div>

            </div>
            <el-form-item prop="text" >
                <richtext v-model="ContentData.text"></richtext>
            </el-form-item>
            <div class="mb-3">
                <el-button type="primary" @click="dialogVisible = true" v-if="!ContentData.vk_url && !ContentData.youtube_url">Добавить видео</el-button>
            </div>
            <el-form-item :inline="true"  style="margin-left: 1rem; margin-bottom: 22px" prop="content_type" :error="errors.get('content_type')">
                <el-checkbox v-model="ContentData.type_text">Текст</el-checkbox>
                <el-checkbox v-model="ContentData.type_image">Изображение</el-checkbox>
                <el-checkbox v-model="ContentData.type_audio">Аудио</el-checkbox>
                <el-checkbox v-model="ContentData.type_video">Видео</el-checkbox>
            </el-form-item>
        </el-form>
        <el-dialog
            v-if="dialogVisible"
            title="Вставьте код видео"
            :visible.sync="dialogVisible"
            width="40%">
            <el-radio-group v-model="videoType"
                            @change="changeVideoType"
                            class="mb-3"
            >
                <el-radio :label="'vk'">Видео из вконтакте</el-radio>
                <el-radio :label="'youtube'">Видео из youtube</el-radio>
            </el-radio-group>
            <el-input
                v-if="videoType === 'vk'"
                type="textarea"
                :rows="5"
                placeholder="Вставьте код видео для vk"
                v-model="vkFrame">
            </el-input>
            <el-input
                v-if="videoType==='youtube'"
                placeholder="Вставьте ссылку на youtube"
                v-model="youtubeInput"
            ></el-input>
            <div id="iframe_container" style="display: none" v-html="vkFrame">
            </div>
            <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="addVideo">Добавить видео</el-button>
           <el-button @click="dialogVisible = false">Отмена</el-button>
  </span>
        </el-dialog>
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
                youtubeInput: "",
                videoType:"vk",
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
            changeVideoType() {
                if(this.videoType === 'youtube') {
                    this.ContentData.vk_url = "";
                    this.vkFrame = "";
                } else if (this.videoType === 'vk') {
                    this.ContentData.youtube_url = "";
                    this.youtubeInput = "";
                }
            },
            deleteVkVideo() {
                this.ContentData.vk_url = "";
                this.ContentData.youtube_url="";
                this.vkFrame = "";
                this.youtubeInput = "";
            },
            addVideo() {
                if(this.videoType === 'youtube') {
                    this.getYoutubeLink();
                } else if (this.videoType === 'vk') {
                    this.getVkUrl();
                }
                this.dialogVisible = false;
            },
            getId(url) {
                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                var match = url.match(regExp);

                if (match && match[2].length == 11) {
                    return match[2];
                } else {
                    return 'error';
                }
            },
            getYoutubeLink() {
                let videoId = this.getId(this.youtubeInput);
                this.ContentData.youtube_url = "//www.youtube.com/embed/" + videoId
            },
            getVkUrl() {
                let url =document.getElementById("iframe_container");
                url = url.getElementsByTagName('iframe');
                if(url.length > 0){

                    url = url[0];
                    url = url.getAttribute('src');
                }
                this.ContentData.vk_url = url;
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
