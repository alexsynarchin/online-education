<template>
    <section>
        <el-form :model="lesson" ref="lesson" :rules="rules" label-position="top">
            <el-form-item label="Название урока" prop="title">
                <el-input v-model="lesson.title"></el-input>
            </el-form-item>
            <el-row type="flex" class="align-items-start justify-content-between mb-3" :gutter="10">

                <el-alert
                    style="margin-right: 0.5rem"
                    title="Желаемая стоимость урока"
                    type="info"
                    show-icon
                    description="Будет принята во внимание при выставлении модератором"
                    :closable="false"
                >
                </el-alert>
                <el-form-item  prop="price" label="Стоимость, руб" style="margin-bottom: 0; margin-right: 2rem" class="label-height-0">
                    <el-input-number v-model="lesson.price" :step="5" :min="5"  ></el-input-number>
                </el-form-item>


                <el-form-item  prop="time" label="Время прохождения, мин" style="margin-bottom: 0; margin-right: 0.45rem; margin-left: auto" class="label-height-0">
                    <el-input-number v-model="lesson.time" :step="5" :min="0"  ></el-input-number>
                </el-form-item>

            </el-row>
            <div class="mb-3">
                <el-button type="primary" @click="dialogVisible = true" v-if="!lesson.vk_url">Добавить видео из вконтакте</el-button>
                <el-button type="danger" @click="deleteVkVideo" v-if="lesson.vk_url">Удалить видео</el-button>
                <div  v-if="lesson.vk_url" class="mt-3">
                    <iframe
                        :src="lesson.vk_url" width="100%" height="480"
                        allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" frameborder="0" allowfullscreen
                    ></iframe>
                </div>

            </div>
            <el-form-item prop="text" label="Содержимое урока">

                <richtext v-model="lesson.text"></richtext>
            </el-form-item>
            <el-form-item :inline="true"  style="margin-left: 1rem; margin-bottom: 22px" prop="content_type" :error="errors.get('content_type')">
                <el-checkbox v-model="lesson.type_text">Текст</el-checkbox>
                <el-checkbox v-model="lesson.type_image">Изображение</el-checkbox>
                <el-checkbox v-model="lesson.type_audio">Аудио</el-checkbox>
                <el-checkbox v-model="lesson.type_video">Видео</el-checkbox>
            </el-form-item>

        </el-form>

        <el-dialog
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
    props: {
        lesson: {
            type:Object,
            requires:true,
        },
        errors: {},
    },
    data() {
        return {
            dialogVisible:false,
            vkFrame:"",
            rules:{
                title:[
                { required: true, message: 'Введите название урока', trigger: 'blur' },
                ],
                price:[
                { required: true, message: 'Введите цены', trigger: 'blur' },
                ],

                time:[
                { type:'number', min: 1, message: 'Время не млжет быть меньше 1 минуты', trigger: 'blur' }
                ],

            },

        }
    },
    methods: {
        deleteVkVideo() {
          this.lesson.vk_url = "";
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
    }
</script>
