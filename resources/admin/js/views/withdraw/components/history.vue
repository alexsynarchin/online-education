<template>
    <section>
        <h1 class="page-title">
            Запросы на вывод средств
        </h1>
        <data-tables :data="withdraws" >
            <el-table-column
                type="index"
            >
            </el-table-column>
            <el-table-column
                label="Преподаватель"
                sortable
            >
                <template slot-scope="scope">
                    {{scope.row.teacher.name}}
                    {{scope.row.teacher.surname}}
                </template>
            </el-table-column>
            <el-table-column
                sortable
                label="Номер карты"
            >
                <template slot-scope="scope">
                    {{scope.row.teacher.teacher_account.card_number}}
                </template>
            </el-table-column>
            <el-table-column
                sortable
                label="Сумма преподавателю"
                prop="sum"
            >

            </el-table-column>
            <el-table-column
                label="Комиссия"
            >
                <template slot-scope="scope">
                    {{scope.row.promo_balance + scope.row.balance - scope.row.sum}}
                </template>
            </el-table-column>
            <el-table-column
                sortable
                label="С баланса"
                prop="balance"
            >

            </el-table-column>
            <el-table-column
                sortable
                label="С промо баланса"
                prop="promo_balance"
            >

            </el-table-column>
            <el-table-column
                sortable
                label="Дата"
                prop="formatted_created_at"
            >

            </el-table-column>
        </data-tables>
    </section>
</template>
<script>
export default {
    data() {
        return {
            withdraws: [],

        }
    },
    methods: {
        handleEdit(index, item) {
            axios.post('/api/admin/withdraw/done', item)
                .then((response) => {
                    this.getWithdraws();
                    this.$notify({
                        title: 'Вывод средств подтвержден',
                        type: 'success',
                        duration:4000
                    });
                })
        },
        getWithdraws() {
            axios.get('/api/admin/withdraws', {params:{done:1}})
                .then((response) => {
                    this.withdraws = response.data;
                })
        }
    },
    mounted() {
        this.getWithdraws();
    }
}
</script>
