<template>
  <el-form :model="form" ref="form" :rules="rules">
    <div class="d-flex align-items-center">
      <el-form-item prop="image" style="margin-bottom: 0; margin-right: 20px" label="Картинка">
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
      <el-form-item label="Ссылка баннера" style="flex: 1">
        <el-input v-model="form.link"></el-input>
      </el-form-item>
        <el-form-item label="Текст">
            <richtext v-model="form.text"></richtext>
        </el-form-item>
    </div>
    <el-button icon="el-icon-plus" type="primary" @click="submitForm('form')">Добавить элемент</el-button>
  </el-form>
</template>
<script>
import richtext from "@/common/js/components/richtext/index.vue";
export default {
    components: {
        richtext,
    },
  data() {
    return {
      form: {
        title: "",
        image: {
          id: "",
          link: "",
        }
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

  }
}
</script>
