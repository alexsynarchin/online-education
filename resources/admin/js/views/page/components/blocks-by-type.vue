<template>
  <section class="blocks-by-type mt-4 mb-4">
      <el-form-item prop="youtube_link" label="Ссылка на youtube">
        <el-input v-model="form.youtube_link"></el-input>
      </el-form-item>
      <el-form-item prop="image" style="margin-bottom: 0;" label="Картинка">
          <el-upload
              action=""
              v-model="form.image.link"
              class="avatar-uploader"
              :auto-upload="false"
              :show-file-list="false"
              :on-change="uploadImage"
          >
              <img v-if="form.image.link" :src="form.image.link" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
      </el-form-item>
      <images-list :delete_img="form.delete_img" :list="form.about_list" @sort="sort"></images-list>
  </section>
</template>
<script>
import ImagesList from "./images-list/index";

  export default {
  components: {
    'ImagesList':ImagesList
  },
    props: {
      blocks: {
        type:Object,
      },
    },
    data() {
      return {
          form: {
            youtube_link:'',
            image:{
                link:"",
            },
            delete_img:[],
            about_list:[],
          },
      }
    },
    methods: {
    sort(data){
      this.form[data.list_name] = data.list;
      console.log(this.form[data.list_name]);
    },
      prepareForm() {
        if(this.blocks.youtube_link) {
          this.form.youtube_link = this.blocks.youtube_link;
        }
        if(this.blocks.about_list) {
          this.form.about_list = this.blocks.about_list;
        }
        if(this.blocks.image) {
          this.form.image = this.blocks.image;
        }
      },
     submitForm() {
      return this.form;
      },
        uploadImage(file){
            let cond = this.beforeImageUpload(file.raw);
            this.form.image['imageName'] = file.raw.name;
            console.log(cond);

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
                vm.form.image.link = e.target.result;
            };
            reader.readAsDataURL(file.raw);
        },
    },
    async mounted() {
      await this.prepareForm();
    },
  }
</script>
