<template>
    <modal
        name="AddStudentPromoModal"
        transition="nice-modal-fade"
        :min-width="200"
        :max-width="400"
        :delay="100"
        :adaptive="true"
        :scrollable="true"
        width="90%"
        height="auto"

        @closed="closeModal"
    >
        <div class="modal-body">
            <div class="modal-heading mb-3">
                <h5 class="modal-heading__title text-center" style="flex: 1">
                    Введите промокод
                </h5>
                <button class="modal-heading__close" @click="closeModal"></button>
            </div>
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


        </div>
    </modal>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
    export default {
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
                this.$modal.hide('AddStudentPromoModal')
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
