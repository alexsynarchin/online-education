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
                label="Сумма"
                prop="sum"
            >

            </el-table-column>
            <el-table-column
                sortable
                label="Сумма c баланса"
                prop="balance"
            >

            </el-table-column>
            <el-table-column
                sortable
                label="Сумма с промо баланса"
                prop="promo_balance"
            >

            </el-table-column>
            <el-table-column
                sortable
                label="Дата"
                prop="formatted_created_at"
            >

            </el-table-column>
            <el-table-column
                label="Действия"
            >

                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="handleEdit(scope.$index, scope.row)">Подтвердить</el-button>

                </template>
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
            axios.get('/api/admin/withdraws')
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
