<template >
    <section v-if="loading">
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a href="/" class="breadcrumb__link">Главная</a>
            </li>
            <li class="breadcrumb__item">
                Профиль пользователя
            </li>
        </ul>
    <h1 class="b-profile-user__title">Мой профиль<span v-if="editing">: редактирование</span></h1>
    <edit-profile v-if="editing " :user="user" @update-user="update" @changeEmail="changeEmail" @cancelEdit="cancelEdit" ></edit-profile>
    <view-profile v-else :user="user"  @handleEdit="handleEdit"></view-profile>
        <el-dialog
            :title=" email_modal_title"
            :visible.sync="email_modal"
            width="30%"
           >
            <p style="word-break: normal">{{email_modal_msg}}</p>
                <el-form :model="emailForm" :rules="email_rules" ref="emailForm" class="mt-3">
                    <el-form-item prop="email" :error="errors.get('email')">
                        <el-input v-model="emailForm.email" placeholder="Электронная почта"></el-input>
                    </el-form-item>
                </el-form>
            <div class="mt-3 d-flex justify-content-center">
                <el-button  type="primary" @click="submitEmailForm('emailForm')">Сохранить</el-button>
                <el-button @click="email_modal = false" v-if="user.email">Отмена</el-button>
            </div>
        </el-dialog>
        <el-dialog
            title="Выберите тип профиля"
            :visible.sync="profile_modal"
            width="30%">
            <el-form :model = "profileForm" :rules="profile_rules" ref="profileForm" >
                <el-form-item prop="profile_type" class="d-flex justify-content-center">
                    <el-radio-group v-model="profileForm.profile_type">
                        <el-radio label="student" border>Учащийся</el-radio>
                        <el-radio label="teacher" border>Преподаватель</el-radio>
                    </el-radio-group>
                </el-form-item>
                <div class="text-center">
                    <el-button  type="primary" @click.prevent="selectProfileType('profileForm')">Сохранить</el-button>
                </div>
            </el-form>
        </el-dialog>
    </section>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
import EditProfile from "./EditProfile";
import ViewProfile from "./ViewProfile";
export default {
    computed:{

        email_modal_title:function () {
            if(!this.user.email) {
                return 'МЫ НЕ ПОЛУЧИЛИ ВАШ EMAIL!'
            } else {
                return 'Смена e-mail'
            }
        },
        email_modal_msg:function () {
            if(!this.user.email) {
                return 'Одну минуту! Мы не получили ваш e-mail.' +
                    ' Электронный адрес необходим для ' +
                    'завершения регистрации и получения полного доступа ко всем возможностям нашего сервиса.'
            } else {
                return 'Введите e-mail'
            }
        }
    },

    components: {
        'EditProfile':EditProfile,
        'ViewProfile':ViewProfile,
    },

    data(){
        return {
            loading:false,
            user: {},
            emailForm:{
                email:""
            },
            email_rules:{
                email:[
                    {required:true,message:'Введите электронную почту'}
                ]
            },
            profile_rules:{
                profile_type:[
                    {required: true, message:'Выберите тип профиля'}
                ]
            },
            profileForm:{
                profile_type:""
            },
            email_modal:false,
            profile_modal:false,
            editing:false,
            errors: new Errors(),
        }
    },
    methods:{
        submitEmailForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    axios.post('/api/profile/user/' + this.user.id +'/update-email',{email:this.emailForm.email})
                        .then((response) => {
                           location.reload(true);
                        })
                        .catch((error) => {
                            this.errors.record(error.response.data.errors);
                        })
                } else {
                    return false;
                }
            });
        },
        update() {
            console.log('success');
            this.editing = false;
            this.loading = false;
            this.getUser();
        },
        changeEmail() {
            this.email_modal = true;
        },
        cancelEdit() {
            this.editing = false;
        },
        selectProfileType(formName) {
            this.$refs[formName].validate((valid) => {
               if(valid) {
                    axios.post('/api/profile/user/' + this.user.id + '/select-profile', {profile_type: this.profileForm.profile_type})
                        .then((response) => {
                            location.reload(true);
                        })
                        .catch((error) => {

                        });
               } else {
                    return false;
               }
            });
        },
        handleEdit() {
            this.editing = true;
        },
            getUser() {
            axios.get('/api/profile/user/show')
                .then((response) => {
                    this.user = response.data;
                    if(!this.user.email) {
                        this.email_modal = true;
                    }
                    if(this.user.email && !this.user.profile_type) {
                        this.profile_modal = true;
                    }
                    if(this.user.email) {
                        this.emailForm.email = this.user.email;
                    }
                    this.loading = true;
                })
        }

    },
    async mounted() {
        await this.getUser();
    }
}
</script>

<style lang="stylus">

@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'
rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-profile-user__title
    margin-top 20px
    font-family 'Raleway', sans-serif
    font-size rem(36px)
    font-weight 700
    color #4B4B4B
    +below(md)
        font-size rem(26px)

.profile-user
    width 100%
    display flex
    justify-content space-between
    margin 30px 0px
    padding 30px 20px
    border 1px dashed #99AEDB
    border-radius 5px
    +below(md)
        flex-direction column
.profile-user-avatar
    width 30%
    &__content
        display flex
        align-items center
    +below(lg)
        width auto
        margin-bottom 10px
    &__img
        margin-right 15px
        border-radius 50%
        width 82px
        height 82px
    &__fullname
        font 500 rem(16px) "Raleway", sans-serif
        color #4B4B4B
.profile-user-edit
    display flex
    align-items center
    margin 15px 0px
    &__icon
        size 15px
        margin-right 10px
        fill #99AEDB
    &__text
        font 500 rem(14px) "Raleway", sans-serif
        text-decoration underline
        color #4B4B4B
.profile-user-transac
    display flex
    flex-direction column
    justify-content center
    margin 0px 0px 15px 0px
    +between(800px,1400px)
        display none
.profile-user-count
    display flex
    align-items center
    &__icon
        size 15px
        margin-right 10px
        fill #99AEDB
.profile-user-text
    margin-right 5px
    color #4B4B4B
    &__score,&__currency
        margin-right 5px
        font 500 rem(14px) "Raleway", sans-serif

.profile-user-withdraw
    display flex
    align-items center
    margin-top 10px
    &__icon
        size 15px
        margin-right 10px
        fill #99AEDB
    &__text
        font 500 rem(14px) "Raleway", sans-serif
        text-decoration underline
        color #4B4B4B

.profile-user-questation:hover .profile-user-questation__popup
    transform translateY(0px)
    opacity 1

.profile-user-questation
    position relative
    &__icon
        position relative
        top -8px
        size 15px
        cursor pointer
    &__popup
        position absolute
        top -80px
        left -100px
        width 350px
        padding 15px
        border-radius 5px
        background-color #6A89CC
        font 500 rem(14px) "Raleway", sans-serif
        color #fff
        opacity 0
        transform translateY(10px)
        transition all .35s ease
        +below(md)
            width 280px
            top -100px
            left -100px
        &::after
            content ''
            position absolute
            bottom -19px
            left 98px
            size 10px
            border: 10px solid transparent
            border-top: 10px solid #6A89CC
.file-upload
    width: 100%;
    position: absolute;
    left: 0;
    opacity: 0;
    cursor: pointer;
</style>

