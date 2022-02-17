<template>
    <el-dialog
        :visible.sync="promoModal"
        :before-close="closeModal"
        class="add-promo-modal"
        append-to-body
    >
        <h3 class="add-promo-modal__title">
            Промокоды
        </h3>
    <el-form  :model="PromoCode" label-position="top" :rules="rules" ref="PromoCode" class="add-promo-modal__form">
        <el-form-item  prop="text" class="add-promo-modal__form-item" :error="errors.get('name')">
            <el-input
                placeholder="Введите промокод для зачисления бонусов"
                class="add-promo-modal__input"
                v-model="PromoCode.name">
            </el-input>
        </el-form-item>
        <el-form-item>
            <button class="btn button" @click.prevent="AddPromo('PromoCode')" >Активировать промокод</button>
        </el-form-item>


    </el-form>
    </el-dialog>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
import Button from "../../components/buying/button";
    export default {
        components: {Button},
        props:{
            promoModal: {
                type:Boolean,
            },
            id: {
                type:Number,
                required:true,
            }
        },
        data(){
            return {
                balance: {},
                PromoCode:{
                    name:""
                },
                rules:{
                    name:[
                        {required:true,message:"Введите значение промокода"}
                    ]
                },
                errors: new Errors(),
            }
        },
        methods:{
            closeModal(){
                this.$emit('close');
            },
            AddPromo(formName){
                axios.post('/api/promo-code/handle',{name:this.PromoCode.name, id:this.id})
                    .then((response)=>{
                        this.$emit('add-promo',response.data);
                        this.closeModal();
                    })
                    .catch((error)=>{
                        this.errors.record(error.response.data.errors)
                    })
            }
        }
    }
</script>
