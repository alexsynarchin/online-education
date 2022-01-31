<template>
        <el-dialog
            :visible.sync="dialogVisible"
            :before-close="handleClose">
            <el-form :model="form" label-position="top" ref="form">
                <el-form-item label="Введите промокод" :error="errors.get('promo')">
                    <el-input v-model="form.promo"></el-input>
                </el-form-item>
                <el-button  type="primary" @click.prevent="" >Купить</el-button>
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
                form: {
                    promo:""
                },
                dialogVisible:false,
                errors: new Errors(),
            }
        },
        methods: {
            closeModal() {
                this.dialogVisible=false;
            },
            handleClose() {

            },
            showModal() {
                this.dialogVisible = true;
            }
        },
        created() {
            EventBus.$on('show-buy-modal', this.showModal)
        }
    }
</script>
