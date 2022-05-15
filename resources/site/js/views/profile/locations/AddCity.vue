<template>
    <el-dialog
        title="Добавить город"
        :visible.sync="modalVisible"
        width="40%"
    >
        <el-form label-position="top" :model="form">
            <el-form-item :error="title_error">
                <el-input v-model="form.title"></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
    <el-button @click="addCity">Добавить</el-button>
    <el-button type="primary" @click="closeModal">Отмена</el-button>
  </span>
    </el-dialog>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
    export default {
        data() {
            return {
                modalVisible:false,
                errors: new Errors(),
                region_id:null,
                form: {
                    title:""
                },
                title_error:""
            }
        },
        methods: {
            openModal(region_id) {
                this.region_id = region_id;
                this.modalVisible = true;
            },
            closeModal() {
                this.errors.clear('title');
                this.form.title = "";
                this.modalVisible = false;
            },
            addCity() {
                axios.post('/api/city/store', {title:this.form.title, region_id:this.region_id})
                    .then((response)=> {
                        this.$emit('addCity', response.data.id);
                        this.closeModal();
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                        if(this.errors.has('title')) {
                            this.title_error = this.errors.get('title');
                        }
                        if(this.errors.has('region_id')) {
                            this.title_error = this.errors.get('region_id');
                        }
                    })
            },
        },
    }
</script>
