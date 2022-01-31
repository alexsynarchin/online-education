<template>
        <el-dialog

            title="Оформление заказа"
            :visible.sync="dialogVisible"
            :before-close="handleClose">
            <el-form :model="data" label-position="top" ref="form">
                <h4>{{data.title}}</h4>
                <div class="d-flex flex-wrap">
                    <div style="margin-right: 20px; font-size: 19px; font-weight: 700">
                        <label>Бонусный баланс:</label>
                        {{data.promo_balance}}
                    </div>
                    <el-form-item class="col-md-5" :error="errors.get('name')">
                        <el-input v-model="PromoCode.name" placeholder="Введите промокод"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button icon="el-icon-plus" type="primary" @click="addPromo">Пополнить</el-button>
                    </el-form-item>
                </div>

                <div class="mb-4" style="font-size: 20px">
                    <label>Сумма к оплате:</label> <span style="font-weight: 700">{{data.discount_price}} руб.</span>
                    <el-button type="primary" @click="calculateDiscount">Использовать бонусный баланс</el-button>
                </div>
                <el-button  type="primary" @click.prevent="">Оплатить</el-button>
                <el-button  type="default" @click.prevent="closeModal">Отмена</el-button>
            </el-form>
        </el-dialog>
</template>
<script>
import EventBus from "../../EventBus";
import { Errors } from  '@/common/js/services/errors.js';
    export default {
        data() {
            return {
                data: {
                    id: null,
                    type: '',
                    title:'',
                    price:0,
                    discount_price:0,
                    account_id:null,
                    promo_balance:0,
                },
                PromoCode: {
                    name:""
                },
                dialogVisible:false,
                errors: new Errors(),
            }
        },
        methods: {
            calculateDiscount(){
                if(this.data.price > this.data.promo_balance) {
                    this.data.discount_price  = this.data.price - this.data.promo_balance;
                    this.data.promo_balance = 0;
                } else {
                    this.data.discount_price = 0;
                    this.data.promo_balance  = this.data.promo_balance - this.data.price;
                }
            },
            addPromo() {
                axios.post('/api/promo-code/handle',{name:this.PromoCode.name, id:this.data.account_id})
                    .then((response)=>{
                        this.data.promo_balance = response.data;
                        this.PromoCode.name = '';
                        this.errors.clear();
                    })
                    .catch((error)=>{
                        this.errors.record(error.response.data.errors)
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
                this.errors.clear();
                this.PromoCode.name="";
                this.dialogVisible=false;
            },
            handleClose() {
                this.closeModal();
            },
            showModal(data) {
                this.getData(data);
                this.dialogVisible = true;
            }
        },
        created() {
            EventBus.$on('show-buy-modal', this.showModal)
        },
        mounted() {
        }
    }
</script>
