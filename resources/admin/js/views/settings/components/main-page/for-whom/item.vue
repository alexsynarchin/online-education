<template>
  <div class="col-md-6 col-xl-4 mb-3">
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
        <div  style="flex: 1">
            <el-form-item label="Заголовок">
                <el-input v-model="item.title"></el-input>
            </el-form-item>
            <el-form-item label="Текст">
                <richtext v-model="item.text"></richtext>
            </el-form-item>
        </div>
      <el-button icon="el-icon-plus" type="danger" @click="deleteItem">Удалить элемент</el-button>
    </el-card>
  </div>
</template>
<script>
import richtext from "@/common/js/components/richtext/index.vue";
export default {
    components:{
        richtext,
    },
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
