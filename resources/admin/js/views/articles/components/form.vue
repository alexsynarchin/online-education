<template>
    <el-form ref="form" :model="form" label-position="top" :rules="rules">
        <el-tabs type="card" v-model="activeTab">
            <el-tab-pane label="Основная информация" name="main">
                <div class="d-flex align-items-center">
                    <el-form-item prop="image" label="Превью" style="margin-bottom: 2rem; margin-right: 0.85rem">
                        <el-upload
                            action=""
                            v-model="form.image"
                            class="avatar-uploader"
                            :auto-upload="false"
                            :show-file-list="false"
                            :on-change="uploadImage"
                        >
                            <img v-if="form.image" :src="form.image" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                    <div  style="flex: 1 0">
                        <div class="row">
                            <el-form-item prop="title" label="Заголовок"  class="col-md-7">
                                <el-input v-model="form.title"></el-input>
                            </el-form-item>
                            <el-form-item label="Опубликован" class="col-md-5"  prop="active" v-if="formAction != '/admin/api/static-page/store'">
                                <el-checkbox v-model="form.active">Опубликован</el-checkbox>
                            </el-form-item>
                        </div>
                        <div class="row">
                            <el-form-item prop="slug" label="URL"  class="col-md-7" :error="errors.get('slug')">
                                <el-input v-model="form.slug"></el-input>
                            </el-form-item>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <richtext v-model="form.text"></richtext>
                            </div>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Настройки и SEO" name="config">
                <Seo :form = "form.seo" v-if="form.seo"></Seo>
            </el-tab-pane>
        </el-tabs>
        <div class="text-right mt-3">
            <el-button type="success" @click="submitForm('form')">Сохранить</el-button>
            <el-button @click="closeModal">Отмена</el-button>
        </div>
    </el-form>
</template>
<script>
    import richtext from '@/common/js/components/richtext/index';
    import { Errors } from  '@/common/js/services/errors.js';
    import Seo from '@/admin/js/components/seo/seo';

    export default {
        props:['form','formAction'],
        components: {
            'Seo':Seo,
            'richtext':richtext,
        },
        data() {
            return {
                activeTab: 'main',
                rules: {
                   title: [
                        { required: true, message: 'Введите заголовок', trigger: 'blur' },
                    ],
                },
                buildings:[],
                errors: new Errors(),
            }
        },
        methods:{
            uploadImage(file){
                let cond = this.beforeImageUpload(file.raw);
                this.form['imageName'] = file.raw.name;
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
                    vm.form.image = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
           async submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$root.isLoading = true;
                        axios.post(this.formAction,this.form)
                            .then((response) => {
                              this.$root.isLoading = false;
                                this.$emit('closeModal','submit')
                            })
                            .catch((error) => {
                              this.$root.isLoading = false;
                                this.errors.record(error.response.data.errors)
                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            closeModal() {
                this.$emit('closeModal','close')
            },

        },
        mounted() {

        }
    }
</script>
<style >
    .preview-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .preview-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .preview-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 280px;
        height: 280px;
        line-height: 280px;
        text-align: center;
    }
    .preview {
        width: 280px;
        height: 280px;
        display: block;
    }
    .ck-editor__editable {
        min-height: 200px;
    }
</style>
