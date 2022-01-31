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
                        v-model="PromoCode.text">
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
            }
        },
        data(){
            return {
                PromoCode:{
                    text:""
                },
                rules:{
                    text:[
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
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                       console.log('success')
                        axios.post('/api/profile/add-promo-code',{name:this.PromoCode.text})
                            .then((response)=>{
                                console.log(response);
                                document.location.reload(true);
                            })
                            .catch((error)=>{

                                this.errors.record(error.response.data.errors)
                            })
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        }
    }
</script>
