<template>
    <el-form :model="cityForm"  ref="cityForm" label-position="top" >
        <el-form-item label="Название города" prop="title" :error="errors.get('title')">
            <el-input v-model="cityForm.title" ></el-input>
        </el-form-item>
        <el-button type="success">Сохранить</el-button>
        <el-button type="default" @click="closeModal">Отмена</el-button>
    </el-form>
</template>
<script>
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props: {
            cityForm: {
                type: Object,
            }
        },
        data() {
            return {
                errors: new Errors(),
            }
        },
        methods: {
            closeModal() {
                this.$emit('close');
            },
        },
    }
</script>
