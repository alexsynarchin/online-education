<template>
    <div style="padding: 40px">
        <el-card class="box-card">
            <el-checkbox v-model="item.border">Нижняя граница</el-checkbox>
            <el-form-item label="Заголовок" >
                <el-input v-model="item.title"></el-input>
            </el-form-item>
            <el-form-item label="Текст">
                <div  style="padding-top: 50px; position: relative;">
                    <div style="position: absolute; top:10px; right: 10px;">
                        <el-button type="primary" size="small" @click="editText" v-if="!edit">Редактировать текст</el-button>
                        <el-button type="success" size="small" @click="saveText" v-if="edit">Сохранить текст</el-button>
                    </div>
                    <div v-html="item.text" v-if="!edit"></div>
                    <richtext v-model="text" v-else></richtext>
                </div>

            </el-form-item>
            <el-form-item>
                <el-checkbox-group v-model="item.cols" v-if="item.cols">
                    <el-checkbox :value="1" label="Картинки в одну колонку"></el-checkbox>
                    <el-checkbox :value="2" label="Option B"></el-checkbox>
                </el-checkbox-group>
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
                <figure v-for="(image, index) in item.images" class="panorama-gallery__item" style="margin-left: 10px">
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
            <el-button icon="el-icon-plus" type="danger" @click="deleteItem">Удалить элемент</el-button>
        </el-card>
    </div>

</template>
<script>
import richtext from "@/common/js/components/richtext/index2.vue";
    export default {
        components:{
            richtext,
        },
        props:{
            item: {
                type:Object,
            }
        },
        data() {
            return {
                text:"",
                upload_image:"",
                delete_img: [],
                edit:false,
                cols: 2,
            }
        },
        methods: {
            editText() {
                this.text = this.item.text;
                this.edit = true;
            },
            saveText() {
                this.item.text = this.text;
                this.edit = false;
                this.text = "";
            },
            deleteItem() {
                this.$emit('delete', this.$vnode.key);
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
                if(this.item.images[index].id) {
                    this.delete_img.push(this.item.images[index].id)
                }
                this.item.images.splice(index,1);
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
                this.item.images.push(image);
                reader.readAsDataURL(file.raw);
            },
        }
    }
</script>
