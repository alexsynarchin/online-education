<template>
    <el-dialog
        title="Добавить регион"
        :visible.sync="modalVisible"
        width="40%"
    >
        <el-form label-position="top" :model="form">
            <el-form-item :error="errors.get('title')">
                <el-input v-model="form.title"></el-input>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="addRegion">Добавить</el-button>
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
              form: {
                title: "",
              },
              errors: new Errors(),
          }
        },
        methods: {
            closeModal() {
                this.errors.clear('title');
                this.form.title = "";
                this.modalVisible = false;
            },
            addRegion() {
                axios.post('/api/region/store', this.form)
                    .then((response)=> {
                        this.closeModal();
                        this.$emit('addRegion', response.data.id)
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            }
        },
    }
</script>
