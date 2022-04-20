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
                        <label for="#number-cart" class="form-pay-group__label">Номер карты</label>
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
                    <div class="availibale-sum">
                        <span class="availibale-sum__text">Доступно к выводу:</span>
                        <span class="availibale-sum__cout"> {{Sum}} </span>
                        <span class="availibale-sum__rub">руб</span>
                    </div>
                    <button class="form-pay__btn" @click.prevent="withdraw">Вывести</button>
                </form>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="payment-types">
                    <div class="payment-types-head">
                        <img class="payment-types-head__item" src="/images/visa.svg" alt="visa">
                        <img class="payment-types-head__item" src="/images/master-card.svg" alt="master-card">
                        <img class="payment-types-head__item" src="/images/mir.svg" alt="mir">
                    </div>
                    <div class="payment-text">
                        <p>
                            Вывод возможен только на карты Visa, MasterCard и МИР с 16-ти и 18-значным номером.
                        </p>
                        <p>
                            Комиссия при выводе составляет:
                        </p>
                        <p>
                            -- На карты РФ: 3%, но не менее 50 руб.;
                        </p>
                        <p> -- На карты мира: 4%, но не менее 300 руб.</p>
                    </div>
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
import transactionTeacher from './components/teacher'
import TransactionStudent from './components/student'
    export default {
    components: {
        transactionTeacher, TransactionStudent,
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
                                this.Sum = parseInt(this.user.teacher_account.balance) + parseInt(this.user.teacher_account.promo_balance);

                            }
                     })
             },

              withdraw() {
                 if(this.withdrawSum > this.Sum) {
                     this.$notify({
                         title: 'Выводимая сумма больше доступной для вывода',
                         type: 'error'
                     });
                 } else {
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
                         })
                 }
                 }

         },
        async mounted() {
            await this.getUser();
        }
    }
</script>
