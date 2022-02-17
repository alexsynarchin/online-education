<template>
  <div class="col-md-4 col-xl-3 mb-3">
    <el-card class="box-card">
            <el-form-item label="Заголовок">
                <el-input v-model="item.title"></el-input>
            </el-form-item>
            <el-form-item label="Цена от" >
                <el-input v-model="item.price"></el-input>
            </el-form-item>
            <el-form-item label="Текст">
                <el-input type="textarea" v-model="item.text"></el-input>
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
      data() {
        return {

        }
      },
    methods: {
      deleteItem() {
        this.$emit('delete', this.$vnode.key);
      },
    }
  }
</script>
