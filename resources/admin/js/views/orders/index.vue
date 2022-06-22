<template>
    <section>
        <h1 class="page-title">
            Заказы
        </h1>
        <data-tables :data="orders" >
            <el-table-column
                label="id"
                prop="id"
            >
            </el-table-column>
            <el-table-column
                label="Тип покупки"
                sortable
            >
                <template slot-scope="scope">
                    <span v-if="scope.row.type === 'course'">
                        Курс
                    </span>
                    <span v-else>
                        Урок
                    </span>
                </template>
            </el-table-column>
            <el-table-column
                sortable
                label="Название"
                prop="name"
            >
            </el-table-column>

            <el-table-column

                label="Преподаватель"
            >
                <template slot-scope="scope">
                   {{scope.row.teacher.name}} {{scope.row.teacher.surname}}
                </template>
            </el-table-column>
            <el-table-column

                label="Студент"
            >
                <template slot-scope="scope">
                    {{scope.row.student.name}} {{scope.row.student.surname}}
                </template>
            </el-table-column>
            <el-table-column

                label="Сумма"
                prop="sum"
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
                        @click="handleView(scope.$index, scope.row)">Подробнее</el-button>

                </template>
            </el-table-column>
        </data-tables>
        <el-dialog
            title="Информация о заказе"
            :visible.sync="dialogVisible"
            width="50%"
            :before-close="handleClose">
            <section class="" style="font-size: 18px" v-if="dialogVisible">
                <div>
                    <label style="font-weight: 700">
                        ID:
                    </label>
                    <span>
                        {{item.id}}
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Тип заказа:
                    </label>
                    <span v-if="item.type === 'course'">
                        Курс
                    </span>
                    <span v-else>
                        Урок
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Название:
                    </label>
                    <span>
                        {{item.name}}
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Сумма:
                    </label>
                    <span>
                        {{item.sum}} руб.
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Сумма с учетом скидки:
                    </label>
                    <span>
                        {{item.money}} руб.
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Бонусы:
                    </label>
                    <span>
                        {{item.bonus}}
                    </span>
                </div>
                <h4 class="mt-3">Преподаватель</h4>
                <div>
                    <label style="font-weight: 700">
                        ID:
                    </label>
                    <span>
                        {{item.teacher.id}}
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Имя:
                    </label>
                    <span>
                        {{item.teacher.name}}
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Фамилия:
                    </label>
                    <span>
                        {{item.teacher.surname}}
                    </span>
                </div>
                <h4 class="mt-3">Студент</h4>
                <div>
                    <label style="font-weight: 700">
                        ID:
                    </label>
                    <span>
                        {{item.student.id}}
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Имя:
                    </label>
                    <span>
                        {{item.student.name}}
                    </span>
                </div>
                <div>
                    <label style="font-weight: 700">
                        Фамилия:
                    </label>
                    <span>
                        {{item.student.surname}}
                    </span>
                </div>
            </section>
            <span slot="footer" class="dialog-footer">
    <el-button @click="dialogVisible = false">Закрыть</el-button>
  </span>
        </el-dialog>
    </section>
</template>
<script>
export default {
    data() {
      return {
          item: {},
          orders: [],
          dialogVisible:false,
      }
    },
    methods: {
        handleView(index, item) {
            this.item = item;
            this.dialogVisible = true;
        },
        handleClose() {
            this.item = {};
            this.dialogVisible = false;
        },
        getOrders() {
            axios.get('/api/admin/orders')
                .then((response) => {
                    this.orders = response.data;
                })
        },
    },
    mounted() {
        this.getOrders();
    }
}
</script>
