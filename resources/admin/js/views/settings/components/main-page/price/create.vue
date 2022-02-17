<template>
  <el-form :model="form" ref="form" :rules="rules">

    <el-form-item label="Заголовок" >
        <el-input v-model="form.title"></el-input>
    </el-form-item>
      <el-form-item label="Цена от" >
          <el-input v-model="form.price"></el-input>
      </el-form-item>
    <el-form-item label="Текст">
        <el-input type="textarea" v-model="form.text"></el-input>
    </el-form-item>
    <el-button icon="el-icon-plus" type="primary" @click="submitForm('form')">Добавить элемент</el-button>
  </el-form>
</template>
<script>
  export default {
    data() {
      return {
        form: {
          title: "",
            price:"",
            text:"",

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


    }
  }
</script>
