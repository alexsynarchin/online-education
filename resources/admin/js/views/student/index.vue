<template>
    <section class="page-content">
        <el-row type="flex" class="mb-3">
            <el-col :span="8">
                <el-input
                    v-model="filters[0].value"
                    size="large"
                    width="100%"
                    placeholder="Поиск: Имя, Фамилия или Отчество"/>
            </el-col>
        </el-row>
        <data-tables :data="students"  :filters="filters">
            <el-table-column
                prop="id"
                label="ID"
            >
            </el-table-column>
            <el-table-column
                label="Фамилия"
                prop="surname"
                sortable
            >
            </el-table-column>
            <el-table-column
                label="Имя"
                prop="name"
                sortable
            >
            </el-table-column>
            <el-table-column
                label="Отчество"
                prop="last_name"
                sortable
            >
            </el-table-column>
            <el-table-column
                label="E-mail"
                prop="email"
                sortable
            >
            </el-table-column>
            <el-table-column
                label="Дата регистрации"
                prop="formatted_created_at"
                sortable
            >
            </el-table-column>
            <el-table-column
                label="Действия"
            >

                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="handleEdit(scope.$index, scope.row)">Просмотр</el-button>

                </template>
            </el-table-column>
        </data-tables>
    </section>
</template>
<script>
export default {
    data() {
        return {
            students:[],
            filters: [
                {
                    prop: ['name', 'surname', 'last_name'],
                    value: ""
                }
            ],
        }
    },
    mounted() {
        this.getStudents();
    },
    methods: {
        handleEdit(index, row) {
            var url = '/admin/students/' + row.id;
            window.location = url;
        },
        getStudents() {
            axios.get('/api/admin/users', {params: {type:'student'}})
                .then((response) => {
                    this.students= response.data;
                })
                .catch((error) => {

                })
        }
    }
}
</script>
