<template>
    <section>

        <el-form :model="lesson" ref="lesson" :rules="rules" label-position="top">
            <el-form-item label="Название урока" prop="title">
                <el-input v-model="lesson.title"></el-input>
            </el-form-item>
            <el-row type="flex" class=" justify-content-end mb-3" :gutter="10">

                <el-alert
                    style="margin-right: 0.5rem; width: auto;"
                    :title="'Рекомендованная цена урока ' + recommended_price + ' руб.'"
                    type="info"
                    show-icon
                    :closable="false"
                >
                </el-alert>
                <el-form-item  prop="price" label="Стоимость, руб" style="margin-bottom: 0; margin-right: 2rem" class="label-height-0">
                    <el-input-number v-model="lesson.price" :step="5" :min="5"  ></el-input-number>
                </el-form-item>


                <el-form-item  prop="time" label="Время прохождения, мин" style="margin-bottom: 0; margin-right: 0.45rem;" class="label-height-0">
                    <el-input-number v-model="lesson.time" :step="5" :min="0"  ></el-input-number>
                </el-form-item>

            </el-row>
            <label for="text" class="el-form-item__label">Содержимое урока</label>
            <div class="mb-3">
                <el-button type="primary" @click="dialogVisible = true" v-if="!lesson.vk_url && !lesson.youtube_url">Добавить видео</el-button>
                <el-button type="danger" @click="deleteVkVideo" v-if="lesson.vk_url || lesson.youtube_url">Удалить видео</el-button>
                <div  v-if="lesson.vk_url" class="mt-3">
                    <iframe
                        :src="lesson.vk_url" width="100%" height="480"
                        allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" frameborder="0" allowfullscreen
                    ></iframe>
                </div>
                <div  v-if="lesson.youtube_url" class="mt-3">
                    <iframe width="100%" height="480" :src="lesson.youtube_url" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <el-form-item prop="text" class="lesson-content">

                <richtext v-model="lesson.text"></richtext>
            </el-form-item>
            <div class="d-flex align-items-center justify-content-between">
                <el-button type="primary" @click="dialogVisible = true" v-if="!lesson.vk_url && !lesson.youtube_url">Добавить видео</el-button>
                <div role="alert" class="el-alert el-alert--info is-light"
                     style="display:block;overflow: visible; position:relative;width:auto;padding-top:0;padding-bottom:0">
                    <el-form-item style="margin-bottom:0" :inline="true">
                        <el-checkbox v-model="lesson.type_text">Текст</el-checkbox>
                        <el-checkbox v-model="lesson.type_image">Изображение</el-checkbox>
                        <el-checkbox v-model="lesson.type_audio">Аудио</el-checkbox>
                        <el-checkbox v-model="lesson.type_video">Видео</el-checkbox>
                    </el-form-item>
                    <div class="el-form-item__error" style="left: 16px" v-if="errors.has('content_type')" v-html="errors.get('content_type')"></div>

                </div>
                <div>
                    <el-button  type="primary" @click.prevent="store(0)"  style="text-transform: uppercase">
                        Сохранить как черновик
                    </el-button>
                    <el-button type="success" @click.prevent="store(1)"  style="text-transform: uppercase">
                        Опубликовать
                    </el-button>
                </div>
            </div>
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
    </section>

</template>
<script>
import Editor from '@tinymce/tinymce-vue'
import richtext from '@/common/js/components/richtext/index';

export default {
    components: {
        richtext,
        'editor': Editor,
    },
    computed: {
        recommended_price(){
            let price = "";
            if(this.edu_type_id===1) {
                price = "20-50";
            } else if(this.edu_type_id === 2) {
                price = "30-70";
            } else if(this.edu_type_id === 3) {
                price = "40-80";
            } else if(this.edu_type_id === 4) {
                price = "40-80";
            }
            return price;
        },
    },
    props: {
        edu_type_id: {},
        lesson: {
            type:Object,
            requires:true,
        },
        errors: {},
    },
    data() {
        return {
            videoType:"vk",
            dialogVisible:false,
            vkFrame:"",
            youtubeInput: "",
            rules:{
                title:[
                { required: true, message: 'Введите название урока', trigger: 'blur' },
                ],
                price:[
                { required: true, message: 'Введите цены', trigger: 'blur' },
                ],

                time:[
                { type:'number', min: 1, message: '', trigger: 'blur' }
                ],

            },

        }
    },
    methods: {
        store(status){
            this.$emit('store', status);
        },
        changeVideoType() {
            if(this.videoType === 'youtube') {
                this.lesson.vk_url = "";
                this.vkFrame = "";
            } else if (this.videoType === 'vk') {
                this.lesson.youtube_url = "";
                this.youtubeInput = "";
            }
        },
        deleteVkVideo() {
          this.lesson.vk_url = "";
          this.lesson.youtube_url="";
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
            this.lesson.youtube_url = "//www.youtube.com/embed/" + videoId
        },
        getVkUrl() {
            let url =document.getElementById("iframe_container");
            url = url.getElementsByTagName('iframe');
            if(url.length > 0){

                url = url[0];
                url = url.getAttribute('src');
            }
           this.lesson.vk_url = url;
            this.dialogVisible =false;
        },
        submit(formName){
            this.$refs[formName].validate((valid) => {
                if (valid) {
                this.$emit('submitStep',true)

                } else {
                this.$emit('submitStep', false);
                return false;
            }
            });
            },

        },
    mounted() {
    }
}
</script>
