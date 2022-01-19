<template>
    <div>
        <el-form label-position="top" :model="formData" ref="formData" :rules="rules" class="profile-user-form mb-3"  @submit.prevent="formSubmit" >
            <div class="d-flex mt-3 mb-4 edu-h-form__settings">
                <div style="margin-right: 20px">
                    <el-form-item prop="avatar">
                        <el-upload
                            action=""
                            v-model="formData.avatar"
                            class="avatar-uploader circle"
                            :auto-upload="false"
                            :show-file-list="false"
                            :on-change="uploadImage"
                        >
                            <img v-if="formData.avatar || user.avatar" :src="formData.avatar ? formData.avatar : user.avatar " class="avatar el-avatar--circle">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                </div>
                <div class="profile-user-form__top-right">
                    <div class="profile-user-form__btns-group">
                        <el-button @click.prevent="changeEmail">Изменить эл. почту</el-button>
                        <el-button @click.prevent="password_modal = true">Изменить пароль</el-button>
                    </div>


                    <el-form-item prop="gender" label="Пол" class="d-flex">
                        <el-radio-group v-model="formData.gender" >
                            <el-radio label="1" border>Женский</el-radio>
                            <el-radio label="2" border>Мужской</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item label="Уведомления" prop="notifications" class="d-flex">
                        <el-switch v-model="formData.notifications" >
                        </el-switch>
                    </el-form-item>
                </div>
            </div>

            <div class="row">
                <el-form-item label="Имя" prop="name" class="col-md-4">
                    <el-input v-model="formData.name"></el-input>
                </el-form-item>
                <el-form-item label="Фамилия" prop="surname" class="col-md-4">
                    <el-input v-model="formData.surname"></el-input>
                </el-form-item>
                <el-form-item label="Отчество" prop="last_name" class="col-md-4">
                    <el-input v-model="formData.last_name"></el-input>
                </el-form-item>
            </div>
            <div class="row">
                <el-form-item  label="Дата рождения" prop="birthday" class="col-md-6">
                    <el-date-picker
                        style="width: 100%"
                        v-model="formData.birthday"
                        type="date"
                        placeholder="Выберите дату рождения">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="Телефон" prop="phone" class="col-md-6">
                    <el-input v-model="formData.phone" v-mask="'+7(###)-##-##-###'" :placeholder="'+7(999)-99-99-999'"></el-input>
                </el-form-item>
            </div>
            <work-places :edu_institutions="user.edu_institutions" @change-work-places="changeWorkPlaces"></work-places>
            <div class="text-center">
                <el-button type="primary" class="" @click.prevent="formSubmit">Сохранить</el-button>
                <el-button type="" class="" @click.prevent="cancelEdit">Отменить</el-button>
            </div>
        </el-form>
        <el-dialog
            title="Сменить пароль"
            :visible.sync="password_modal"
            width="40%"
        >
            <el-form :model="passwordForm" :rules="password_rules" ref="passwordForm" label-position="top">
                <el-form-item prop="current_password" :error="errors.get('current_password')" label="Текущий пароль">
                    <el-input v-model="passwordForm.current_password" placeholder="Введите текущий пароль" show-password></el-input>
                </el-form-item>
                <el-form-item prop="new_password" :error="errors.get('new_password')" label="Новый пароль">
                    <el-input v-model="passwordForm.new_password" placeholder="Введите новый пароль" show-password></el-input>
                </el-form-item>
                <el-form-item prop="new_password_confirmation" label="Новый пароль еще раз">
                    <el-input v-model="passwordForm.new_password_confirmation" placeholder="Повторите новый пароль" show-password></el-input>
                </el-form-item>
            </el-form>
            <div class="mt-3 d-flex justify-content-center">
                <el-button  type="primary" @click="submitPasswordForm('passwordForm')">Сохранить</el-button>
                <el-button @click="password_modal = false">Отмена</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script>
    import WorkPlaces from "./work-places";
    import {mask} from 'vue-the-mask'
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props:{
            user: {
            type:Object,
            required:true
            }
        },
        directives: {mask},
        components: {
            WorkPlaces,
        },
        data() {
            return {
                loading:false,
                options: [
                    { text: 'Мужской', value: 2 },
                    { text: 'Женский', value: 1 },
                ],
                password_rules: {
                    current_password: [
                        {required:true, message: 'Введите текущий пароль'}
                    ],
                    new_password: [
                        {required:true, message: 'Введите новый пароль'}
                    ],
                    new_password_confirmation: [
                        {required:true, message: 'Повторите новый пароль'}
                    ],
                },
                passwordForm: {
                    current_password:"",
                    new_password: "",
                    new_password_confirmation: ""

                },
                formData: {},
                password_modal:false,
                rules:{

                },
                errors: new Errors(),
            }
        },
        methods:{
            uploadImage(file){
                let cond = this.beforeImageUpload(file.raw);
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
                    vm.formData.avatar = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
            submitPasswordForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if(valid) {
                        axios.post('/api/profile/' + this.user.id + '/change-password', this.passwordForm)
                            .then((response) => {
                                this.password_modal = false;
                                this.$refs[formName].resetFields();
                                this.$message({
                                    message: response.data,
                                    type: 'success'
                                });

                            })
                            .catch((error) => {
                                this.errors.record(error.response.data.errors);
                            })
                    } else {
                        return false;
                    }
                });

            },
            cancelEdit() {
                this.$emit('cancelEdit');
            },
            changeEmail() {
                this.$emit('changeEmail')
            },
            formSubmit(){
                var data = this.formData;
                axios.post('/api/profile/user/' + this.user.id + '/update', data)
                    .then((response) => {
                        this.$emit('update-user');
                    })
                    .catch(function (error) {
                        var errors = error.response;
                        if(errors.statusText === 'Unprocessable Entity' || errors.status === 422){
                            console.log(errors.data);
                            var er_data =  errors.data.errors;
                        }
                    });
            },
            changeWorkPlaces(places) {
                this.formData.places = places;
            }
        },
      mounted() {
            console.log(this.user);
         this.formData = this.user;
         this.loading = true;
        }
    }
</script>
<style lang="scss" scoped>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader.circle .el-upload {
        border-radius: 100%;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
        &--circle{
            border-radius:100%;
        }
    }
</style>
