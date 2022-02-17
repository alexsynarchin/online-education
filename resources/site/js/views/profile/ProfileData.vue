<template>
    <div>
        <section class="profile-data">
            <section class="profile-data__left">
                <figure class="profile-data-avatar">
                    <img class="profile-data-avatar__img" :alt="formData.name + ' ' +  formData.surname" :src="formData.avatar" id="profile-pic">
                </figure>
                <el-upload
                    class="text-center"
                    action=""
                    :show-file-list="false"
                    :on-change="uploadImage">
                    <button class="btn button button--transparent profile-data-avatar__upload">Загрузить фото</button>
                </el-upload>
                <div class="profile-data-notifications">
                    <label class="profile-data-notifications__label">
                        Уведомления
                    </label>
                    <el-switch
                        v-model="formData.notifications"
                        @change="formSubmit"
                        class="profile-data-notifications__switch">
                    </el-switch>
                </div>

            </section>
            <div class="profile-data__content">
                <el-form :model="formData" class="profile-data-form">
                    <div class="profile-data-form__fullname" v-if="profileEdit">
                        <el-form-item prop="name">
                            <el-input
                                v-model="formData.name">
                            </el-input>
                        </el-form-item>
                        <el-form-item prop="surname">
                            <el-input
                                v-model="formData.surname">
                            </el-input>
                        </el-form-item>
                    </div>
                    <h3 class="profile-data__fullname" v-else>
                        {{user.name}}
                        {{user.surname}}
                    </h3>
                    <div class="profile-data__actions">
                        <h4 class="profile-data__type">
                            {{profile_type}}
                        </h4>
                        <button class="btn profile-data__edit-btn" @click.prevent="handleEdit" v-if="!profileEdit">Редактировать</button>
                    </div>
                    <div class="profile-data-head">
                        Данные пользователя
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Дата регистрации:</span>
                        <span class="profile-data-item__value">{{user.formatted_created_at}}</span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Пол:</span>
                        <el-form-item prop="gender" class="d-flex" v-if="profileEdit">
                            <el-radio-group v-model="formData.gender" >
                                <el-radio label="1" border>Женский</el-radio>
                                <el-radio label="2" border>Мужской</el-radio>
                            </el-radio-group>
                        </el-form-item>
                        <span class="profile-data-item__value" v-else>{{user.gender_string}}</span>

                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Дата рождения:</span>
                        <el-form-item prop="birthday" v-if="profileEdit">
                            <el-date-picker
                                style="width: 100%"
                                v-model="formData.birthday"
                                type="date"
                                placeholder="Выберите дату рождения">
                            </el-date-picker>
                        </el-form-item>
                        <span class="profile-data-item__value" v-else>{{user.formatted_birthday}}</span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Город:</span>
                        <el-select  v-model="formData.city" placeholder="Выберите город" v-if="profileEdit">
                            <el-option
                                v-for="item in cities"
                                :key="item"
                                :value="item">
                            </el-option>
                        </el-select>
                        <span class="profile-data-item__value" v-else>{{user.city}}</span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Образование:</span>
                        <span class="profile-data-item__value"></span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Профильные предметы:</span>
                        <span class="profile-data-item__value"></span>
                    </div>
                    <div class="profile-data-head">
                        Контакты
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">E-mail:</span>
                        <el-form-item prop="email" v-if="profileEdit">
                            <el-input
                                v-model="formData.email">
                            </el-input>
                        </el-form-item>
                        <span class="profile-data-item__value" v-else>{{user.email}}</span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Телефон:</span>
                        <el-form-item prop="email" v-if="profileEdit">
                            <el-input
                                v-mask="'+7(###)-##-##-###'"
                                :placeholder="'+7(999)-99-99-999'"
                                v-model="formData.phone">
                            </el-input>
                        </el-form-item>
                        <span class="profile-data-item__value" v-else>{{user.phone}}</span>
                    </div>
                    <div class="text-center mb-5 mt-5" v-if="profileEdit">
                        <el-button type="success" class="" @click.prevent="formSubmit">Сохранить</el-button>
                        <el-button type="" class="" @click.prevent="cancelEdit">Отменить</el-button>
                    </div>
                </el-form>
                <div class="profile-data-transactions"  v-if="user.profile_type === 'student'">
                    <div class="profile-data-transactions__content">
                        <label class="profile-data-transactions__label">
                            Бонусов на счету:
                        </label>
                        <span class="profile-data-transactions__value">
                             {{user.student_account.promo_balance}}
                        </span>

                    </div>
                    <button class="btn button" @click="addPromo">
                        Активировать промокод
                    </button>
                </div>
            </div>
        </section>
        <add-student-promo

            v-if="promoModal && user.profile_type === 'student'"
            @close="closePromoModal"
            @add-promo="saveBalance"
            :promoModal="promoModal"
            :id="user.student_account.id"
        ></add-student-promo>
    </div>
</template>
<script>
    import AddStudentPromo from "./AddStudentPromo";
    import {mask} from 'vue-the-mask';
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        components: {AddStudentPromo},
        props: {
            user: {
                type: Object,
            }
        },
        directives: {mask},
        data() {
            return {
                promoModal:false,
                profileEdit:false,
                formData: this.user,
                cities: [
                    'Москва', 'Уфа'
                ],
                errors: new Errors(),
            }
        },
        computed:{
            profile_type:function () {
                let profile_type;
                switch (this.user.profile_type) {
                    case 'teacher':
                        profile_type = 'Преподаватель';
                        break;
                    case 'student':
                        profile_type = 'Учащийся';
                        break;
                    default:
                        profile_type = '';
                        break;
                }
                return profile_type;
            },
        },
        methods: {
            saveBalance(balance) {
                this.user.student_account.promo_balance = balance;
                this.closePromoModal();
            },
            formSubmit(){
                var data = this.formData;
                axios.post('/api/profile/user/' + this.user.id + '/update', data)
                    .then((response) => {
                        this.$emit('update-user');
                        this.$notify({
                            title: 'Профиль обновлен',
                            type: 'success'
                        });
                        this.profileEdit = false;
                    })
                    .catch(function (error) {
                        var errors = error.response;
                        if(errors.statusText === 'Unprocessable Entity' || errors.status === 422){
                            console.log(errors.data);
                            var er_data =  errors.data.errors;
                        }
                    });
            },
            cancelEdit() {
                this.profileEdit = false;
                this.formData = this.user;
            },
            addPromo()
            {
                this.promoModal = true;
            },
            closePromoModal() {
                this.promoModal = false;
            },
            handleEdit(){
                this.profileEdit = true;
            },
            uploadImage(file){
                let cond = this.beforeImageUpload(file.raw);
                console.log(cond);
                this.formData['imageName'] = file.raw.name;
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
                this.formSubmit();
            },
        },
        async mounted() {

        }
    }
</script>
