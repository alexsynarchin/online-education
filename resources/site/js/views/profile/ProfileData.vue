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
                        <span class="profile-data-item__label">ID:</span>
                        <span class="profile-data-item__value">{{user.id}}</span>
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
                        <span class="profile-data-item__label">Регион:</span>
                        <div class="d-flex align-items-center" v-if="profileEdit">
                            <el-select  v-model="formData.region_id" placeholder="Выберите регион"  @change="selectRegion(formData.region_id)">
                                <el-option
                                    v-for="item in regions"
                                    :key="item.id"
                                    :label="item.title"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                            <el-button size="small" style="margin-left: 10px" icon="el-icon-plus" type="primary" @click="RegionModal = true">Добавить</el-button>
                        </div>

                        <span class="profile-data-item__value" v-else>{{user.region_title}}</span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Город:</span>
                        <div class="d-flex align-items-center" v-if="profileEdit">
                        <el-select  v-model="formData.city_id" placeholder="Выберите город" >
                            <el-option
                                v-for="item in cities"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id">
                            </el-option>
                        </el-select>
                            <el-button size="small" style="margin-left: 10px" icon="el-icon-plus" type="primary" @click="CityModal = true">Добавить</el-button>
                        </div>
                        <span class="profile-data-item__value" v-else>{{user.city}}</span>
                    </div>
                    <!--
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Образование:</span>
                        <span class="profile-data-item__value"></span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Профильные предметы:</span>
                        <span class="profile-data-item__value"></span>
                    </div>
                    -->
                    <div class="profile-data-head">
                        Контакты
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">E-mail:</span>
                        <div class="d-flex align-items-center" style="margin-bottom: 22px" v-if="profileEdit">
                        <el-form-item prop="email" style="margin-bottom: 0">
                            <el-input
                                v-model="formData.email">
                            </el-input>
                        </el-form-item>
                            <el-button v-if="!formData.email_verified_at" size="small" type="primary" style="margin-left: 10px" @click.prevent="confirmEmail">Подтвердить</el-button>
                        </div>
                        <span class="profile-data-item__value" v-else>{{user.email}}</span>
                    </div>
                    <div class="profile-data-body__item profile-data-item">
                        <span class="profile-data-item__label">Телефон:</span>
                        <div class="d-flex align-items-center" style="margin-bottom: 22px" v-if="profileEdit">
                            <el-form-item   style="margin-bottom: 0" :error="errors.get('phone')">
                                <el-input
                                    v-mask="'+7(###)-##-##-###'"
                                    :placeholder="'+7(999)-99-99-999'"
                                    v-model="formData.phone">
                                </el-input>
                            </el-form-item>
                            <el-button v-if="!formData.phone_confirmation" size="small" type="primary" style="margin-left: 10px" @click.prevent="phoneConfirmationModal = true">Подтвердить</el-button>
                        </div>

                        <span class="profile-data-item__value" v-else>{{user.phone}}</span>
                    </div>
                    <div class="profile-data-head" v-if="user.profile_type === 'teacher'">
                        Места работы
                    </div>

                    <work-places
                        v-if="user.profile_type === 'teacher'"
                                :edit="profileEdit"
                                :edu_institutions="user.edu_institutions"
                                :regions="regions"
                                @getRegions="getRegions"
                                 @change-work-places="changeWorkPlaces"
                    ></work-places>

                    <div class="text-center mb-5 mt-5" v-if="profileEdit">
                        <el-button type="success" class="" @click.prevent="formSubmit">Сохранить</el-button>
                        <el-button type="" class="" @click.prevent="cancelEdit">Отменить</el-button>
                    </div>

                </el-form>
            </div>
        </section>
        <el-dialog
            title="Подтвердите номер телефона"
            :visible.sync=" phoneConfirmationModal"
            width="40%">
            <el-alert
                :closable="false"
                class="mb-3"
                style="word-break: break-word;"
                title="Вам поступит звонок-сброс с уникального номера. Введите последние 6 цифр этого номера"
                type="info"></el-alert>
            <el-form label-position="top"  :model="phoneConfirmationForm"
                     class="profile-data-form d-flex align-items-end"
                     style="margin-bottom: 28px">
                <el-form-item label="Код подтверждения" prop="code" style="flex:1" :error="errors.get('code')">
                    <el-input style="" v-model="phoneConfirmationForm.code"></el-input>
                </el-form-item>
                <el-button type="primary" @click.prevent="sendConfirmPhoneCode(0)">Выслать код</el-button>
            </el-form>
            <el-alert
                class="mb-3"
                v-if="errors.has('phone')"
                type="error"
                :closable="false"
                :title="errors.get('phone')"
            ></el-alert>
            <el-alert
                v-if="countDown > 0"
                :closable="false"
                class="mb-3"
                style="word-break: break-word;"
                :title="'Вы можете отправить код повторно через ' +  countDown + ' сек.' "
                type="warning"></el-alert>
            <el-alert
                v-if="check_code"
                class="mb-3"
                title="Если вам не пришел входящий звонок по истечению 1 минуты, вы сможете запросить звонок с озвучиванием кода роботом при звонке"
                type="warning"
                :closable="false"
                center
                show-icon>
            </el-alert>
            <el-button class="mb-3"  v-if="check_code && countDown === 0"
                       type="primary"
                       @click.prevent="sendConfirmPhoneCode(1)">
                Выслать код с озвучиванием роботом</el-button>
            <div class="text-center">
                <el-button type="success" @click.prevent="confirmPhoneCode(check_code)">
                    Подтвердить
                </el-button>
            </div>
        </el-dialog>
        <el-dialog
            style="max-width: 320px"
            title="Добавить регион"
            :visible.sync="RegionModal"
            width="100%"
            v-if="RegionModal"
        >
            <el-form label-position="top" :model="RegionForm">
                <el-form-item :error="errors.get('title')">
                    <el-input v-model="RegionForm.title"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="addRegion">Добавить</el-button>
                <el-button type="primary" @click="closeRegionModal">Отмена</el-button>
            </span>
        </el-dialog>
        <el-dialog
            title="Добавить город"
            :visible.sync="CityModal"
            v-if="CityModal"
            width="40%"
            >
            <el-form label-position="top" :model="CityForm">
                <el-form-item :error="errors.get('title')">
                    <el-input v-model="CityForm.title"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
    <el-button @click="addCity">Добавить</el-button>
    <el-button type="primary" @click="closeCityModal">Отмена</el-button>
  </span>
</el-dialog>
    </div>
</template>
<script>
    import EventBus from '@/site/js/EventBus.js'
    import {mask} from 'vue-the-mask';
    import { Errors } from  '@/common/js/services/errors.js';
    import WorkPlaces from "./work-places";
    export default {
        components: {WorkPlaces,},
        props: {
            user: {
                type: Object,
            }
        },
        directives: {mask},
        data() {
            return {
                check_code:"",
                countDown:0,
                phoneConfirmationForm: {
                    code: ""
                },
                RegionForm: {
                    title: ""
                },
                CityForm: {
                    title: ""
                },
                phoneConfirmationModal:false,
                CityModal:false,
                RegionModal:false,
                profileEdit:false,
                formData: this.user,
                cities: [],
                regions:[],
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
            sendConfirmPhoneCode(voice) {
                if(this.countDown === 0) {
                    axios.post('/api/profile/user/phone-confirmation', {phone:this.formData.phone, voice:voice, code:this.check_code})
                        .then((response) => {
                            console.log(response.data);
                            this.countDown = 60;
                           if(response.data.code){
                                this.check_code = response.data.code;
                            }
                            this.countDownTimer();
                        })
                        .catch((error) => {
                            this.errors.record(error.response.data.errors);
                        })
                }
            },
            confirmPhoneCode(code) {
                axios.post('/api/profile/user/phone-check-code', {check_code:code, code:this.phoneConfirmationForm.code, phone:this.formData.phone})
                    .then((response) => {
                        this.formData.phone_confirmation = true;
                        this.phoneConfirmationModal = false;
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            },
            countDownTimer () {

                if (this.countDown > 0) {
                    setTimeout(() => {
                        this.countDown -= 1
                        this.countDownTimer()
                    }, 1000)
                }
            },
            addRegion() {
                axios.post('/api/region/store', this.RegionForm)
                    .then((response)=> {
                        this.formData.region_id = response.data.id;
                        this.getRegions();
                        this.closeRegionModal();
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            },

            closeRegionModal() {
                this.errors.clear('title');

                this.RegionForm.title = "";
                this.RegionModal = false;
            },
            closeCityModal(){
                this.errors.clear('title');
                this.CityForm.title = "";
                this.CityModal = false;
            },
            addCity() {
                axios.post('/api/city/store', {title:this.CityForm.title, region_id:this.formData.region_id})
                    .then((response)=> {
                        this.formData.city_id = response.data.id;
                        this.getCities();
                        this.closeCityModal();
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            },
            getRegions() {
                axios.get('/api/regions')
                    .then((response) => {
                        this.regions = response.data;
                    })

            },
            selectRegion(region_id) {
                this.formData.city_id = null;
                this.getCities(region_id)
            },
            getCities(region_id) {
                axios.get('/api/cities', {params:{region_id:region_id}})
                    .then((response) => {
                        this.cities = response.data;
                    })
            },
            changeWorkPlaces(places) {
                this.formData.places = places;
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
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    });
            },
            cancelEdit() {
                this.profileEdit = false;
                this.formData = this.user;
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
            confirmEmail() {
                axios.post('/api/profile/user/email/verification-notification')
                    .then((response)=> {
                        this.$notify({
                            title: 'Письмо отправлено на вашу почту',
                            message: 'На вашу почту придет письмо для верификации профиля',
                            type: 'success',
                            duration:30000,
                        });
                    })
            }
        },
        async mounted() {
            this.getRegions();
            if(this.formData.profile_type === 'teacher' && this.formData.edu_institutions.length === 0) {
                let offset = 0;
                if(!this.formData.phone_confirmation) {
                    offset =100;
                }
                this.profileEdit = true;
                this.$notify({
                    offset:offset,
                    duration:30000,
                    title: 'Добавьте место работы',
                    message: 'Ваш профиль станет отображаться на странице "Поиск преподавателя"',
                    type: 'warning'
                });
            }
            if(!this.formData.phone_confirmation) {
                this.profileEdit = true;
                this.$notify({
                    title: 'Подтвердите номер телефона',
                    message: 'Для верификации профиля',
                    type: 'warning',
                    duration:30000,
                });
            }
            if(this.formData.region_id) {
                this.getCities(this.formData.region_id);
            }
        },
        created() {
            EventBus.$on('show-promo-modal', this.addPromo);
        },
    }
</script>
