<template>
        <form  class="modal-form" novalidate role="form">
            <div class="modal-form-group">
                <input class="modal-form-group__input form-control" type="text" name="name" placeholder="Имя" v-model="registerData.name" :class="{'is-invalid' : errors.get('name')}" required>
                <div class="invalid-feedback">
                    {{errors.get('name')}}
                </div>
            </div>
            <div class="modal-form-group">
                <input class="modal-form-group__input form-control" type="text" name="surname" placeholder="Фамилия"  v-model="registerData.surname" :class="{'is-invalid' : errors.get('surname')}" required>
                <div class="invalid-feedback">
                    {{errors.get('surname')}}
                </div>
            </div>
            <div class="modal-form-group">
                <input class="modal-form-group__input form-control" type="mail" name="email" placeholder="email" v-model="registerData.email" :class="{'is-invalid' : errors.get('email')}" required>
                <div class="invalid-feedback">
                    {{errors.get('email')}}
                </div>
            </div>
            <div class="modal-form-group">
                <input class="modal-form-group__input form-control" type="password" name="password" placeholder="Пароль" v-model="registerData.password" :class="{'is-invalid' : errors.get('password')}" required>
                <div class="invalid-feedback">
                    {{errors.get('password')}}
                </div>
            </div>
            <div  class="modal-form-group">
                <input class="modal-form-group__input" type="password" name="password_confirmation" placeholder="Повторите пароль" v-model="registerData.password_confirmation" :class="{'is-invalid' : errors.get('password')}" required>
            </div>
            <fieldset class="modal-form-group modal-group--column">
                <h3 class="modal-form-group__title">Хочу зарегистрироваться как:</h3>
                <div class="modal-radio-group"  >
                        <label for="student_f" class="modal-radio-group-item">
                            <span class="modal-radio-item">
                                 <input class="modal-radio-item__radio" v-on:change="setProfileType" type="radio" name="profile_type" value="student" id="student_f"  v-model="registerData.profile_type">
                            <span></span>
                            </span>
                            <span class="modal-radio-group__title">Ученик</span>
                        </label>
                        <label  for="teacher" class="modal-radio-group-item">
                            <span class="modal-radio-item">
                                <input class="modal-radio-item__radio" v-on:change="setProfileType" type="radio" name="profile_type" value="teacher" id="teacher" v-model="registerData.profile_type">
                            <span></span>
                            </span>
                            <span class="modal-radio-group__title">Преподаватель</span>
                        </label>
                </div>
                <span class="text-danger error-text" role="alert" v-if="errors.get('profile_type')" style="font-size: 80%">
                                    {{errors.get('profile_type')}}
                </span>
            </fieldset>
            <button class="modal-form-btn" type="submit" @click.prevent="registerPost()">Зарегистрироваться</button>
            <div class="modal-form-polytic">
                <span class="modal-form-polytic__text">Нажимая кнопку «Зарегистрироваться» вы принимаете условия</span>
                <span class="modal-form-polytic__conf">Пользовательское соглашения</span>
            </div>
        </form>
</template>

<script>
    import { Errors } from  '@/common/js/services/errors.js';

    export default{
        components:{

        },
        data(){
            return{
                registerData:{
                    name:'',
                    email:'',
                    surname:'',
                    profile_type:'',
                    password:'',
                    password_confirmation:''
                },

                errors: new Errors(),
            }
        },
        methods:{
            registerPost(){

                axios.post('/register', this.registerData)
                    .then((response) => {
                        location.replace('/profile');
                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    });
            },
            setProfileType() {
                this.$emit('setProfileType',this.registerData.profile_type)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }

    }

</script>
