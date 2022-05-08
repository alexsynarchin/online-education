<template>
    <el-form :model="cityForm"  ref="cityForm" label-position="top" >
        <el-form-item label="Название региона" prop="title" :error="errors.get('title')">
            <el-input v-model="cityForm.title" ></el-input>
        </el-form-item>
        <el-button type="success" @click="saveForm">Сохранить</el-button>
        <el-button type="default" @click="closeModal">Отмена</el-button>
    </el-form>
</template>
<script>
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props: {
            action: {
                type: String
            },
            cityForm: {
                type: Object,
            }
        },
        data() {
            return {
                errors: new Errors(),
            }
        },
        methods: {
            closeModal() {
                this.$emit('close');
            },
            saveForm() {
              axios.post(this.action, this.cityForm)
                  .then((response)=>{
                      this.$notify({
                          title: 'Информация  сохранена',
                          type: 'success'
                      });
                      this.closeModal();
                  })
                  .catch((error)=>{
                      this.errors.record(error.response.data.errors);
                  })
            },
        },
    }
</script>
