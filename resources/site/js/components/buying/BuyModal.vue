<template>
        <el-dialog
            class="order-modal"
            :visible.sync="dialogVisible"
            :before-close="handleClose">
            <el-form :model="data" label-position="top" ref="form">
                <h3 class="order-modal__title">
                    Оформить заказ
                </h3>
                <div class="order-modal__item">
                    <figure class="order-modal__item-preview">
                        <img :src="data.preview">
                    </figure>
                    <div class="order-modal__item-content">
                        <h4 class="order-modal__item-title-1">{{data.title}}</h4>
                        <h4 class="order-modal__item-title-2">{{data.edu_type_title}}</h4>
                    </div>
                    <span class="order-modal__item-price">
                        {{data.price}} ₽
                    </span>
                </div>
                <div class="order-modal__promo-heading">
                    <label class="order-modal__promo-label">
                        Списать бонусы:
                    </label>
                    <div class="order-modal__promo-balance">
                        <label class="order-modal__promo-balance-label">
                            Баланс:
                        </label>
                        <span class="order-modal__promo-balance-val">
                            {{data.promo_balance}} бонусов
                        </span>
                    </div>
                </div>
                <div class="form-group order-modal__promo-form">
                    <input placeholder="Сумма списания"
                           class="form-control order-modal__promo-input"
                           :class="{'is-invalid': errors.has('discount')}"
                           v-model="discount"
                           @input="calculateDiscount"
                    ></input>
                    <div class="invalid-feedback"  v-text="errors.get('discount')"></div>
                </div>
                <div class="order-modal__promo-descr">
                    Есть сертификат?  <a href="" @click.prevent="addPromoCode">Введите его </a>  и получите бонусы на счет
                </div>
                <div class="order-modal__sum">
                   <label class="order-modal__sum-label">
                       Сумма с учетом бонусов:
                   </label>
                    <span class="order-modal__sum-val">
                         {{data.discount_price}} ₽
                    </span>
                </div>
                <button class="btn button"  @click.prevent="payment">Оплатить</button>
            </el-form>
            <add-student-promo
                v-if="promoModal"
                @close="closePromoModal"
                @add-promo="saveBalance"
                :promoModal="promoModal"
                :id="data.account_id"
            ></add-student-promo>
        </el-dialog>
</template>
<script>
import EventBus from "../../EventBus";
import { Errors } from  '@/common/js/services/errors.js';
import AddStudentPromo from '@/site/js/views/profile/AddStudentPromo';
import Button from "./button";
    export default {
        components: {Button, AddStudentPromo},
        data() {
            return {
                discount:"",
                promoModal:false,
                data: {
                    id: null,
                    type: '',
                    title:'',
                    price:0,
                    edu_type_title:'',
                    preview:'',
                    discount_price:0,
                    account_id:null,
                    promo_balance:0,
                },
                dialogVisible:false,
                errors: new Errors(),
            }
        },
        methods: {
            addPromoCode() {
                this.promoModal = true;
            },
            closePromoModal() {
                this.promoModal = false;
            },
            saveBalance(balance) {
                console.log(balance);
                this.data.promo_balance = balance - this.discount;
                this.closePromoModal();
            },
            calculateDiscount(){
                let discount = this.discount;
                if(this.discount === '') {
                    discount = 0;
                }
                if(discount > this.data.price) {
                    this.discount = this.data.price;
                    discount = this.data.price;
                }
                axios.post('/api/buying/handle-discount', {discount:discount, price:this.data.price, balance:this.data.promo_balance})
                .then((response) => {
                    this.errors.clear();
                    this.data.discount_price = response.data.discount_price;
                    this.data.promo_balance = response.data.promo_balance;
                })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
            },
            getData(data) {
                axios.get('/api/buying/data', {params:data})
                    .then((response) => {
                        this.data = response.data;
                        this.data.discount_price = response.data.price;
                    })
            },
            closeModal() {
                this.discount = '';
                this.errors.clear();
                this.dialogVisible=false;
            },
            handleClose() {
                this.closeModal();
            },
            showModal(data) {
                this.getData(data);
                this.dialogVisible = true;
            },
            payment() {
                axios.post('/api/buying/buy', this.data)
                .then((response) => {
                    window.location.href = response.data;
                })
            },
        },
        created() {
            EventBus.$on('show-buy-modal', this.showModal)
        },
        mounted() {
        }
    }
</script>
