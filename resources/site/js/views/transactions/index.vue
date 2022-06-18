<template>
    <section>
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                Транзакции
            </li>
        </ul>
        <h1 class="b-profile-user__title" v-if="user.profile_type === 'teacher'">Вывести средства</h1>
        <div class="row" v-if="user.profile_type === 'teacher'">
            <div class="col-sm-12 col-md-12 col-lg-6">

                <form class="form-pay">
                    <fieldset class="form-pay-group">
                        <label for="#number-cart" class="form-pay-group__label">Номер банковской карты</label>
                        <input  v-model="user.teacher_account.card_number"
                                type="text"
                                id="number-cart"
                                class="form-pay-group__input"
                                placeholder="">
                    </fieldset>
                    <fieldset class="form-pay-group">
                        <label for="#sum" class="form-pay-group__label">Сумма</label>
                        <input v-model="withdrawSum" type="text" id="sum" class="form-pay-group__input" placeholder="">
                    </fieldset>
                    <div class="availibale-sum" >
                        <span class="availibale-sum__text">Переведем на карту с учетом комиссии:</span>
                        <span class="availibale-sum__cout"> {{SumWithPercent}} </span>
                        <span class="availibale-sum__rub">руб</span>
                    </div>
                    <div class="availibale-sum" style="font-weight: 700">
                        <span class="availibale-sum__text">Доступно к выводу:</span>
                        <span class="availibale-sum__cout"> {{Sum}} </span>
                        <span class="availibale-sum__rub">руб</span>
                    </div>

                    <button class="form-pay__btn" @click.prevent="withdraw">Вывести</button>
                </form>
                <section class="withdraw-alert">
                    <div class="d-flex">
                        <i class="el-icon-info" style="color:#e44e36; font-size: 26px; margin-right: 10px"></i>
                        <div>
                            <p style="margin-bottom: 15px">
                                Вы можете вывести бонусы в размере не более 25% от суммы денежного счета
                            </p>
                            <p style="font-weight: 700">
                                Вывести бонусы можно только после подтверждения номера телефона
                            </p>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="payment-types">
                    <div class="payment-types-head">
                        <img class="payment-types-head__item" src="/images/visa.svg" alt="visa">
                        <img class="payment-types-head__item" src="/images/master-card.svg" alt="master-card">
                        <img class="payment-types-head__item" src="/images/mir.svg" alt="mir">
                    </div>
                    <p class="payment-text">
                        Вывод возможен только на карты Visa, MasterCard и МИР с 16-ти и 18-значным номером.
                    </p>
                    <section class="withdraw-alert">
                        <div class="d-flex">
                            <i class="el-icon-info" style="color:#e44e36; font-size: 26px; margin-right: 10px"></i>
                            <div>

                                <p>
                                    Комиссия сервиса составляет не более 25% на денежный и бонусный счет.
                                </p>
                                <p>Снимается при выводе средств</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <transaction-teacher
            v-if="user.profile_type==='teacher'"
            ref="teacher"
        ></transaction-teacher>
        <transaction-student v-else></transaction-student>
    </section>
</template>
<script>
import transactionTeacher from './components/teacher';
import EventBus from '../../EventBus';
import TransactionStudent from './components/student';
    export default {
    components: {
        transactionTeacher, TransactionStudent,
    },
        computed: {
            SumWithPercent:function (){
                let sum = this.withdrawSum * 0.25;
                sum = this.withdrawSum - sum;
                sum =parseInt(sum);
                return sum;
            }
        },
        data() {
            return {
                user: {},
                Sum: 0,
                withdrawSum:0,

            }
        },
         methods: {
             getUser() {
                 axios.get('/api/profile/user/show')
                     .then((response) => {
                         this.user = response.data;
                            if(this.user.profile_type === 'teacher') {
                                this.Sum = parseInt(this.user.teacher_account.balance);
                                let withdraw_promo = parseInt(this.user.teacher_account.promo_balance);
                                let percent = (this.Sum / 100) * 25;
                                if (withdraw_promo > percent) {
                                    withdraw_promo = percent;
                                }
                                this.Sum = this.Sum + withdraw_promo;
                                this.Sum = parseInt(this.Sum);
                            }
                     })
             },

              withdraw() {
                 if(this.withdrawSum > this.Sum) {
                     this.$notify({
                         title: 'Выводимая сумма больше доступной для вывода',
                         type: 'error'
                     });

                 }
                  else if(!this.user.phone_confirmation) {
                      this.$notify({
                          title: 'Подтвердите номер телефона',
                          type: 'error'
                      });
                  }
                  else if(this.user.has_wait_withdraw) {
                     this.$notify({
                         title: 'Дождитесь подтверждения предыдущего вывода средств',
                         type: 'error'
                     });
                 }
                 else if(this.withdrawSum > 0){
                     axios.post('/api/profile/withdraw',
                         {user_id:this.user.id,
                             sum:this.Sum,
                             withdraw_sum:this.withdrawSum,
                             card_number:this.user.teacher_account.card_number
                         })
                         .then((response) => {
                             console.log(response.data);
                             this.$notify({
                                 title: 'Запрос на вывод средств отправлен',
                                 type: 'success'
                             });
                             this.$refs.teacher.getWithdraws();
                             this.getUser();
                             EventBus.$emit('sidebar-balance');
                         })
                 }
                 }

         },
        async mounted() {
            await this.getUser();
        }
    }
</script>
