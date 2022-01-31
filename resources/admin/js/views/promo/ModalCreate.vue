<template>
            <el-form :model="promoForm" :rules="rules" ref="promoForm" label-position="top" >
                <el-row type="flex" :gutter="15">
                    <el-col :span="14">
                        <el-form-item label="Время действия" prop="range">
                            <el-date-picker
                                v-model="promoForm.range"
                                type="daterange"
                                range-separator="/"
                                start-placeholder="Дата начала"
                                end-placeholder="Дата завершения"
                                format="dd-MM-yyyy"
                                style="width: 100%"
                            >
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="Сумма на баланс, руб" prop="sum">
                            <el-input-number v-model="promoForm.sum" :step="100" :min="100"  step-strictly></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="15">
                    <el-col :span="14">
                        <el-form-item label="Промокод (значение)" prop="name" :error="errors.get('name')">
                            <el-input v-model="promoForm.name" ></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="Количество использований" prop="max_count">
                            <el-input-number v-model="promoForm.max_count" :step="10" :min="0" ></el-input-number>
                        </el-form-item>
                    </el-col>
                </el-row>
                <div class="d-flex justify-content-center">
                    <el-button icon="el-icon-plus" type="success" style="margin-right: 1rem" @click.prevent="submitForm('promoForm')">Добавить</el-button>
                    <el-button @click="closeModal">Отмена</el-button>
                </div>
            </el-form>

</template>
<script>
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        mounted(){
            console.log('Modal mounted')
        },
        data(){
            return{
                promoForm:{
                    range:"",
                    name:"",
                    sum:100,
                    max_count:0
                },
                rules:{
                    name:[
                        {required:true, message:"Поле «Промокод» не может быть пустым"},
                    ],
                    range:[
                        {required: true, message:"Выберите временной промежуток"}
                    ],
                    max_count:[
                        { type:'number', min: 1, message: 'Количество не может быть меньше 1', trigger: 'blur' }
                    ],
                    sum:[
                        {type:'number', min: 0, message:"Поле «Сумма на баланс» не может 0"}
                    ],
                },
                errors: new Errors(),
            }
        },
        methods:{
            closeModal(){
                this.$modal.hide('CreatePromoModal')
                this.$emit('finish')
            },
            beforeOpen(){

            },
            beforeClose(){

            },
            submitForm(formName){
                this.$refs[formName].validate((valid) => {
                    if(valid) {
                        this.errors.clear();
                        axios.post('/api/admin/promo-code/store', this.promoForm)
                            .then((response)=>{
                                this.$emit('updateTableData','Промокод создан');
                                this.$emit('finish');
                            })
                            .catch((error)=>{
                                console.log(error);
                                this.errors.record(error.response.data.errors);
                            })
                    } else {
                        return false;
                    }
                });
            }
        }
    }
</script>
