<template>
    <el-dialog
        title="Введите промокод"
        :visible.sync="promoModal"
        width="30%"
        :before-close="closeModal"
    >
    <el-form :model="PromoCode" label-position="top" :rules="rules" ref="PromoCode" class="mb-3">
        <el-form-item label="Промокод" prop="text" :error="errors.get('name')">
            <el-input
                v-model="PromoCode.name">
            </el-input>
        </el-form-item>
        <div class="d-flex justify-content-center">
            <el-button type="success" @click.prevent="AddPromo('PromoCode')" >Ввести</el-button>
            <el-button @click.prevent="closeModal">Отменить</el-button>
        </div>

    </el-form>
    </el-dialog>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
    export default {
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
                        this.closeModal();
                    })
                    .catch((error)=>{
                        this.errors.record(error.response.data.errors)
                    })
            }
        }
    }
</script>
