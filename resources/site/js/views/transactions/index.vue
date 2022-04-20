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
        <h1 class="b-profile-user__title">Вывести средства</h1>
        <div class="row" v-if="user.profile_type === 'teacher'">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <form class="form-pay">
                    <fieldset class="form-pay-group">
                        <label for="#number-cart" class="form-pay-group__label">Номер карты</label>
                        <input type="text" id="number-cart" class="form-pay-group__input" placeholder="">
                    </fieldset>
                    <fieldset class="form-pay-group">
                        <label for="#sum" class="form-pay-group__label">Сумма</label>
                        <input type="text" id="sum" class="form-pay-group__input" placeholder="">
                    </fieldset>
                    <div class="availibale-sum">
                        <span class="availibale-sum__text">Доступно к выводу:</span>
                        <span class="availibale-sum__cout">  </span>
                        <span class="availibale-sum__rub">руб</span>
                    </div>
                    <button class="form-pay__btn" type="submit">Вывести</button>
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
    </section>
</template>
<script>
    export default {
        data() {
            return {
                user: {}
            }
        },
         methods: {
             getUser() {
                 axios.get('/api/profile/user/show')
                     .then((response) => {
                         this.user = response.data;

                     })
             }
         },
        async mounted() {
            await this.getUser();
        }
    }
</script>
