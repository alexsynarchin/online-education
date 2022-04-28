<template>
    <el-form ref="form" :model="form" class="mb-4">
        <div class="row">
            <el-form-item class="col-md-6" :error="errors.get('theme')">
                <el-input v-model="form.theme" placeholder="Тема сообщения"></el-input>
            </el-form-item>
            <el-form-item class="col-md-6" :error="errors.get('type')">
                <el-select v-model="form.type" placeholder="Выберите тип пользователя" style="width: 100%">
                    <el-option label="Учащийся" value="student"></el-option>
                    <el-option label="Преподаватель" value="teacher"></el-option>
                </el-select>
            </el-form-item>
        </div>
        <div class="row">
            <el-form-item class="col-md-6" :error="errors.get('name')">
                <el-input v-model="form.name" placeholder="Имя"></el-input>
            </el-form-item>
            <el-form-item class="col-md-6" :error="errors.get('email')">
                <el-input v-model="form.email" placeholder="e-mail"></el-input>
            </el-form-item>
        </div>
        <el-form-item>
            <el-input type="textarea" v-model="form.text" placeholder="Текст сообщения" :error="errors.get('text')"></el-input>
        </el-form-item>
        <div class="text-center">
            <button class="btn button" @click.prevent="sendMessage">Отправить сообщение</button>
        </div>
    </el-form>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
    export default {
        data() {
            return {
                form: {
                    type:'',
                    theme:'',
                    name: '',
                    email: '',
                    text: '',
                },
                errors: new Errors(),
            }
        },
        methods: {
            sendMessage() {
                axios.post('/api/contact', this.form)
                    .then((response) =>  {
                        console.log(response.data);
                        this.$notify({
                            title: 'Ваше сообщение отправлено',
                            type: 'success'
                        });
                    })
                    .catch((error) => {
                        this.$root.isLoading = false;
                        this.errors.record(error.response.data.errors);
                    })
            }
        }
    }
</script>
