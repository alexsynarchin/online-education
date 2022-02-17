<template>
  <div class="col-md-4 col-xl-3 mb-3">
    <el-card class="box-card">
      <el-form-item prop="image" style="margin-bottom: 0;" label="Картинка">
        <el-upload
            action=""
            v-model="item.image.link"
            class="avatar-uploader"
            :auto-upload="false"
            :show-file-list="false"
            :on-change="uploadImage"
        >
          <img v-if="item.image.link" :src="item.image.link" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="Ссылка баннера">
        <el-input v-model="item.link"></el-input>
      </el-form-item>
      <el-button icon="el-icon-plus" type="danger" @click="deleteItem">Удалить элемент</el-button>
    </el-card>
  </div>
</template>
<script>
export default {
  props:{

    item: {
      type:Object,
    }
  },
  methods: {
    deleteItem() {
      this.$emit('delete', this.$vnode.key);
    },
    uploadImage(file){
      let cond = this.beforeImageUpload(file.raw);
      this.item.image['imageName'] = file.raw.name;
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
        vm.item.image.link = e.target.result;
      };
      reader.readAsDataURL(file.raw);
    },
  }
}
</script>
