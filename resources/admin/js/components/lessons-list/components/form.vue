<template>
    <el-form :model="lesson" ref="lesson" :rules="rules" label-position="top">
        <el-form-item label="Название урока" prop="title">
            <el-input v-model="lesson.title"></el-input>
        </el-form-item>
        <el-row type="flex" class="justify-content-end mb-3" :gutter="10">

            <el-alert
                style="margin-right: 0.5rem; width: auto;"
                :title="'Рекомендованная цена урока ' + recommended_price + ' руб.'"
                type="info"
                show-icon
                :closable="false"
            ></el-alert>
            <el-form-item  prop="price" label="Стоимость, руб" style="margin-bottom: 0; margin-right: 2rem" class="label-height-0">
                <el-input-number v-model="lesson.price" :step="50" :min="50"  step-strictly></el-input-number>
            </el-form-item>


            <el-form-item  prop="time" label="Время прохождения, мин" style="margin-bottom: 0; margin-right: 0.45rem;" class="label-height-0">
                <el-input-number v-model="lesson.time" :step="5" :min="0"  step-strictly></el-input-number>
            </el-form-item>

        </el-row>
    </el-form>
</template>
<script>

    export default {
        props: {
            lesson: {
                type:Object,
                requires:true,
            },
            edu_type_id: {},
        },
        computed: {
            recommended_price(){
                let price = "";
                if(this.edu_type_id===1) {
                    price = "20-50";
                } else if(this.edu_type_id === 2) {
                    price = "30-70";
                } else if(this.edu_type_id === 3) {
                    price = "40-80";
                } else if(this.edu_type_id === 4) {
                    price = "40-80";
                }
                return price;
            },
        },
        data() {
            return {
                rules:{
                    title:[
                        { required: true, message: 'Введите название урока', trigger: 'blur' },
                    ],
                    price:[
                        { required: true, message: 'Введите цены', trigger: 'blur' },
                    ],

                    time:[
                        { type:'number', min: 1, message: 'Время не млжет быть меньше 1 минуты', trigger: 'blur' }
                    ],
                },
            }
        },
        methods: {
            submit(formName){
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('submitStep',true)

                    } else {
                        this.$emit('submitStep', false);
                        return false;
                    }
                });
            },

        },
    }
</script>
