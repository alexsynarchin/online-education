<template>
    <el-dialog
    :visible.sync="modalVisible"
    class="auth-modal"
    >
    <h5 >
        Восстановление пароля
    </h5>
        <el-tabs v-model="activeName" @tab-click="handleClick" v-if="!codeCheck">
            <el-tab-pane name="email" label="По e-mail">
                <form role="form">
                    <div class="d-flex align-items-center modal-form-group">
                        <div style="flex: 1">
                            <input class="modal-form-group__input form-control" type="mail" name="email" placeholder="email"
                                   v-model="form.email" :class="{'is-invalid' : errors.get('email')}">
                            <div class="invalid-feedback">
                                {{errors.get('email')}}
                            </div>
                        </div>
                        <el-button type="primary" size="medium" style="margin-left: 10px" @click.prevent="sendCode(activeName, 0)">
                            Отправить код
                        </el-button>
                    </div>
                    <el-alert
                        v-if="form.emailCode"
                        class="mb-3"
                        title="На ваш электронный адрес было отправлено письмо с кодом"
                        type="warning"
                        :closable="false"
                        center
                        show-icon>
                    </el-alert>
                    <div class="modal-form-group">
                        <input class="modal-form-group__input form-control"
                               type="text"
                               placeholder="Введите код"
                               v-model="form.check_code"
                               :class="{'is-invalid' : errors.get('check_code')}">
                        <div class="invalid-feedback">
                            {{errors.get('check_code')}}
                        </div>
                    </div>
                    <div class="text-center">
                        <el-button type="success" @click.prevent="confirmCode">
                            Подтвердить код
                        </el-button>
                    </div>
                </form>

            </el-tab-pane>
            <el-tab-pane name="phone" label="По номеру телефона">
                <form role="form">
                    <div class="d-flex align-items-center modal-form-group">
                        <div style="flex: 1">
                            <input class="modal-form-group__input form-control"
                                   v-mask="'+7(###)-##-##-###'"
                                   :placeholder="'+7(999)-99-99-999'"
                                   type="text" name="phone"
                                   v-model="form.phone" :class="{'is-invalid' : errors.get('phone')}">
                            <div class="invalid-feedback">
                                {{errors.get('phone')}}
                            </div>
                        </div>
                        <el-button type="primary" size="medium" style="margin-left: 10px" @click.prevent="sendCode(activeName, 0)">
                            Отправить код
                        </el-button>
                    </div>
                    <el-alert
                        v-if="countDown > 0"
                        :closable="false"
                        class="mb-3"
                        style="word-break: break-word;"
                        :title="'Вы можете отправить код повторно через ' +  countDown + ' сек.' "
                        type="warning"></el-alert>
                    <el-alert
                        v-if="form.phoneCode"
                        class="mb-3"
                        title="Если вам не пришел входящий звонок по истечению 1 минуты, вы сможете запросить звонок с озвучиванием кода роботом при звонке"
                        type="warning"
                        :closable="false"
                        center
                        show-icon>
                    </el-alert>
                    <el-button class="mb-3"  v-if="form.phoneCode && countDown === 0"
                               type="primary"
                               @click.prevent="sendCode(activeName, 1)">
                        Выслать код с озвучиванием роботом</el-button>
                    <div class="modal-form-group">
                        <input class="modal-form-group__input form-control"
                               type="text"
                               placeholder="Введите код"
                               v-model="form.check_code"
                               :class="{'is-invalid' : errors.get('check_code')}">
                        <div class="invalid-feedback">
                            {{errors.get('check_code')}}
                        </div>
                    </div>
                    <div class="text-center">
                        <el-button type="success" @click.prevent="confirmCode">
                            Подтвердить код
                        </el-button>
                    </div>
                </form>
            </el-tab-pane>


        </el-tabs>
        <form v-else>
            <div class="modal-form-group">
                <input class="modal-form-group__input form-control" type="password"

                       placeholder="Пароль"
                       v-model="passForm.password"
                       :class="{'is-invalid' : errors.get('password')}" required>
                <div class="invalid-feedback">
                    {{errors.get('password')}}
                </div>
            </div>
            <div class="modal-form-group">
                <input class="modal-form-group__input form-control" type="password"

                       placeholder="Подтвердите пароль"
                       v-model="passForm.password_confirmation"
                >
            </div>
            <div class="text-center">
                <el-button type="success" @click.prevent="changePass">
                    Сменить пароль
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>
<script>
    import EventBus from "../../EventBus";
    import { Errors } from  '@/common/js/services/errors.js';
    import {mask} from 'vue-the-mask';
    export default {
        directives: {mask},
        data() {
            return {
                user_id:null,
                countDown:0,
                codeCheck:false,
                activeName: "email",
                passForm: {
                    password: "",
                    password_confirmation: "",
                    user_id: null,
                },
                form: {
                    check_code: "",
                    email: "",
                    phone: "",
                    phoneCode: "",
                    emailCode: "",
                    voice:0,
                },

                modalVisible:false,
                errors: new Errors(),
            }
        },
        methods: {
            changePass() {
                this.passForm.user_id = this.user_id;
                axios.post('/api/restore-password/change',this.passForm)
                    .then((response) => {
                        this.modalVisible = false;
                        this.form.emailCode = "";
                        this.form.phoneCode = "";
                        this.form.check_code = "";
                        this.codeCheck = false;
                        this.errors.clear();
                        this.$notify({
                            title: 'Ваш пароль изменет',
                            type: 'success'
                        });

                    })
                    .catch((error) => {
                        this.errors.record(error.response.data.errors);
                    })
            },
            confirmCode() {
                axios.post('/api/restore-password/' + this.activeName+ '/confirm-code',this.form)
                    .then((response) => {
                        this.codeCheck = response.data;
                    })
                    .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
            },
            handleClick(){
                if(this.activeName === 'email') {
                    this.form.phoneCode = "";
                }
                if(this.activeName === 'phone') {
                    this.form.emailCode = "";
                }
                this.form.check_code = "";
            },
            showModal() {
                console.log('open')
                this.modalVisible = true;
            },
            sendCode(type, voice) {
                this.form.voice = voice;
               axios.post('/api/restore-password/' + type +'/send-code', this.form)
                   .then((response) => {
                       if(this.activeName === 'phone') {
                           this.countDown = 60;
                           if(response.data.result.code){
                               this.form.phoneCode = response.data.result.code;
                           }
                           this.countDownTimer();
                       }
                       if(this.activeName === 'email') {
                            this.form.emailCode = response.data.code;
                       }
                       this.user_id = response.data.user_id;
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
        },
        created() {
            EventBus.$on('show-restore-modal', this.showModal);
        }
    }
</script>
