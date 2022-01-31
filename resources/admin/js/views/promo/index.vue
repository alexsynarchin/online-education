<template>
    <section class="promo-list">
        <div class="col-md-10">
            <el-row type="flex" class="mb-3">
                <el-col :span="12">
                    <el-button type="success" icon="el-icon-plus" @click.prevent="openModal()">Новый промокод</el-button>
                </el-col>
                <el-col :span="12">
                    <el-input
                        v-model="filters[0].value"
                        size="large"
                        width="100%"
                        placeholder="Название промокода"/>
                </el-col>
            </el-row>
            <data-tables :data="tableData"  :filters="filters">
                <el-table-column
                    type="index"
                >
                </el-table-column>
                <el-table-column
                    label="Промокод"
                    prop="name"
                    width="200"
                    sortable
                >
                </el-table-column>
                <el-table-column
                    sortable
                    label="Действует с"
                    prop="start_time"
                >

                </el-table-column>
                <el-table-column
                    sortable
                    label="Заканчивается"
                    prop="end_time"
                >
                </el-table-column>
                <el-table-column
                    sortable
                    label="Количество"
                    prop="max_count"
                >
                </el-table-column>
                <el-table-column
                    sortable
                    label="На баланс, руб"
                    prop="sum"
                >
                </el-table-column>
            </data-tables>
        </div>
        <el-dialog
            title="Новый промокод"
            :visible.sync="modalCreate"
            width="50%"
            >
            <modal-create @finish = "closeModal" v-if="modalCreate" @updateTableData="updateTableData"/>
        </el-dialog>
    </section>
</template>
<script>
import ModalCreate from "./ModalCreate";

export default {
    mounted(){
        this.getPromoCodes();
    },
    components:{
        ModalCreate,
    },
    data(){
        return{
            PromoList:[],
            modalCreate:false,
            filters: [{
                prop: 'name',
                value: ''
            }],
            tableData:[],
            editData:{}
        }
    },
    methods:{
        openModal(){
            this.modalCreate = true;

        },
        closeModal(){
            this.modalCreate=false;
        },
        getPromoCodes(){
            axios.get('/api/admin/promo-code/list')
                .then((response)=>{
                    this.tableData = response.data;
                })
        },
        updateTableData(message){
            this.getPromoCodes();
            this.$notify({
                title: 'Отлично',
                message: message,
                type: 'success',
                duration:4000
            });
        }

    }
}
</script>
