<template>
    <div>
        <section class="profile-data">
            <section class="profile-data__left">
                <figure class="profile-data-avatar">
                    <img class="profile-data-avatar__img" :alt="user.name + ' ' +  user.surname" :src="user.avatar" id="profile-pic">
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
                    <el-switch v-model="user.notifications" class="profile-data-notifications__switch">
                    </el-switch>
                </div>

            </section>

            <div class="profile-data__content">
                <h3 class="profile-data__fullname">
                    {{user.name}}
                    {{user.surname}}
                </h3>
                <div class="profile-data__actions">
                    <h4 class="profile-data__type">
                        {{profile_type}}
                    </h4>
                    <button class="btn profile-data__edit-btn" @click.prevent="handleEdit">Редактировать</button>
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
                    <span class="profile-data-item__value">{{user.gender_string}}</span>
                </div>
                <div class="profile-data-body__item profile-data-item">
                    <span class="profile-data-item__label">Дата рождения:</span>
                    <span class="profile-data-item__value">{{user.formatted_birthday}}</span>
                </div>
                <div class="profile-data-body__item profile-data-item">
                    <span class="profile-data-item__label">Город:</span>
                    <span class="profile-data-item__value">{{user.city}}</span>
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
                    <span class="profile-data-item__value">{{user.email}}</span>
                </div>
                <div class="profile-data-body__item profile-data-item">
                    <span class="profile-data-item__label">Телефон:</span>
                    <span class="profile-data-item__value">{{user.phone}}</span>
                </div>
                <div class="profile-data-transactions">
                    <div class="profile-data-transactions__content" v-if="user.profile_type === 'student'">
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
            v-if="promoModal"
            @close="closePromoModal"
            @add-promo="saveBalance"
            :promoModal="promoModal"
            :id="user.student_account.id"
        ></add-student-promo>
    </div>
</template>
<script>
    import AddStudentPromo from "./AddStudentPromo";
    export default {
        components: {AddStudentPromo},
        props: {
            user: {
                type: Object,
            }
        },
        data() {
            return {
                promoModal:false,
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
            addPromo()
            {
                this.promoModal = true;
            },
            closePromoModal() {
                this.promoModal = false;
            },
            handleEdit(){

            },
            uploadImage(file){
                let cond = this.beforeImageUpload(file.raw);
                console.log(cond);
                this.user['imageName'] = file.raw.name;
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
                    vm.user.avatar = e.target.result;
                };
                reader.readAsDataURL(file.raw);
            },
        }
    }
</script>
