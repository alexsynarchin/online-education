<template>
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
