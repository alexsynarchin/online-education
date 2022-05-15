<template>
    <el-dialog
        title="Добавить учебное заведение"
        :visible.sync="modalVisible"
        width="40%"
    >
        <el-form label-position="top" :model="form">
            <el-form-item :error="title_error">
                <el-input v-model="form.title"></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
    <el-button @click="addItem">Добавить</el-button>
    <el-button type="primary" @click="closeModal">Отмена</el-button>
  </span>
    </el-dialog>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props: {
            city_id: {
                type:Number
            },
            type: {

            }
        },
        data() {
            return {
                modalVisible:false,
                form: {
                    title:""
                },
                title_error:"",
                errors: new Errors(),
            }
        },
        methods: {
            closeModal() {
                this.errors.clear('title');
                this.form.title = "";
                this.modalVisible = false;
            },
            addItem(){
                axios.post('/api/edu-institution/store', {title:this.form.title, city_id:this.city_id, type:this.type})
                    .then((response)=> {
                        this.$emit('addEduInstitution', {id:response.data.id, title: response.data.title});
                        this.closeModal();
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                        if(this.errors.has('title')) {
                            this.title_error = this.errors.get('title');
                        }
                        if(this.errors.has('city_id')) {
                            this.title_error = this.errors.get('city_id');
                        }
                        if(this.errors.has('type')) {
                            this.title_error = this.errors.get('type');
                        }
                    })
            },
        }
    }
</script>
