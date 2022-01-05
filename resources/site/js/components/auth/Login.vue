<template>
    <form role="form" class="modal-form">
        <div class="modal-form-group">
            <input class="modal-form-group__input form-control" type="mail" name="email" placeholder="email"  v-model="loginDetails.email" :class="{'is-invalid' : errors.get('email')}">
            <div class="invalid-feedback">
                {{errors.get('email')}}
            </div>
        </div>
        <div class="modal-form-group">
            <input class="modal-form-group__input form-control" type="password" name="password" placeholder="Пароль" v-model="loginDetails.password" :class="{'is-invalid' : errors.get('password')}">
            <div class="invalid-feedback">
                {{errors.get('password')}}
            </div>
        </div>
        <div class="modal-form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="loginDetails.remember"  name="remember" > Запомнить меня
                    </label>
                </div>
            </div>
        </div>
        <button class="modal-form-btn" type="submit" @click.prevent="loginPost">Вход</button>
    </form>

</template>

<script>
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props: {
            redirect_path: {
                type:String,
            }
        },
        components:{
        },
        data(){
            return{
                loginDetails:{
                    email:'',
                    password:'',
                    remember:true
                },
                errors: new Errors(),
            }

        },
        methods:{
            loginPost(){
                axios.post('/login', this.loginDetails)
                    .then((response) =>  {
                        window.location = response.data;
                    })
                    .catch((error) =>  {
                        this.errors.record(error.response.data.errors);
                    });
            }
        },
        mounted() {
        }
    }
</script>
