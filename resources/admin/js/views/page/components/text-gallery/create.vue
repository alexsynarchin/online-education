<template>
    <section>
        <el-form :model="form" label-position="top" ref="form" :rules="rules">
            <el-form-item label="Заголовок" >
                <el-input v-model="form.title"></el-input>
            </el-form-item>
            <el-form-item label="Текст">
                <richtext v-model="form.text"></richtext>
            </el-form-item>
            <div class="d-flex mb-4">
                <el-upload
                    action=""
                    v-model="upload_image"
                    class="avatar-uploader"
                    :auto-upload="false"
                    :show-file-list="false"
                    :on-change="uploadImage"
                >
                 <i  class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
                <figure v-for="(image, index) in form.images" class="panorama-gallery__item" style="margin-left: 10px">
                    <img  :src="image.link"  class="">
                    <span class="panorama-gallery__item-actions">
                      <span
                          class="panorama-gallery__item-delete"
                          @click="handleRemove(index)"
                      >
                <i class="el-icon-delete"></i>
                      </span>
                    </span>
                </figure>

            </div>
            <el-button icon="el-icon-plus" type="primary" @click="submitForm('form')">Добавить элемент</el-button>
        </el-form>
    </section>
</template>
<script>
import richtext from "@/common/js/components/richtext/index.vue";
    export default {
        components: {
            richtext,
        },
        data() {
            return {
                upload_image:"",
                form: {
                    title: "",
                    text: "",
                    images:[],
                },
                rules: {
                    title: [
                        {required:true, message: "Заполните заголовок"}
                    ]
                },
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('submit', this.form);
                    } else {
                        return false;
                    }
                });
            },
            uploadImage(file){
                let cond = this.beforeImageUpload(file.raw);
                //this.form.image['imageName'] = file.raw.name;
                console.log(cond);

                if(cond){
                    this.createImage(file);
                }
            },
            handleRemove(index) {
                if(this.form.images[index].id) {
                    this.delete_img.push(this.form.images[index].id)
                }
                this.form.images.splice(index,1);
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
                let image = {
                    id: null,
                    link:"",
                    name: "",
                }
                image.name = file.raw.name;
                reader.onload = (e) => {
                    image.link = e.target.result;
                };
                this.form.images.push(image);
                reader.readAsDataURL(file.raw);
            },
        }
    }
</script>
