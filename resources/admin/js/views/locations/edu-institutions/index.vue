<template>
    <section>
        <h1 class="page-title">
            Города и учебные заведения
        </h1>
        <el-row type="flex" class="mb-3">
            <el-col :span="12">
                <el-button type="success" icon="el-icon-plus" @click.prevent="addCity">Добавить Учебное заведение</el-button>
            </el-col>
            <el-col :span="12">
                <el-input
                    v-model="filters[0].value"
                    size="large"
                    width="100%"
                    placeholder="Название учебного заведения"/>
            </el-col>
        </el-row>
        <data-tables :data="items"  :filters="filters">
            <el-table-column
                type="index"
            >
            </el-table-column>
            <el-table-column
                label="Название"
                prop="title"
                width="200"
                sortable
            >
            </el-table-column>
            <el-table-column
                label="Тип"
                width="200"
                sortable
            >
                <template slot-scope="scope">
                    <template v-if="scope.row.type === 'university'">
                        Высшее
                    </template>
                    <template v-else>
                        Школа
                    </template>
                </template>
            </el-table-column>
            <el-table-column
                label="Регион"
                width="200"
                sortable
            >
                <template slot-scope="scope">
                    {{scope.row.region.title}}
                </template>
            </el-table-column>
            <el-table-column
                label="Город"
                width="200"
                sortable
            >
                <template slot-scope="scope">
                    {{scope.row.city.title}}
                </template>
            </el-table-column>
            <el-table-column
                label="Действия"
            >
                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="handleEdit(scope.row.id)">Редактировать</el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click="handleRemove(scope.row.id)">Удалить</el-button>
                </template>
            </el-table-column>
        </data-tables>
        <el-dialog
            :title="ModalTitle"
            :visible.sync="dialogVisible"
            width="50%"
            :before-close="handleClose">
            <create v-if="formState === 'create'" @close="handleClose"></create>
            <edit :id="id" v-if="formState === 'edit'" @close="handleClose"></edit>
        </el-dialog>
    </section>
</template>
<script>
    import create from './create';
    import edit from './edit';
    export default {
        components: {
            create, edit,
        },
        computed: {
            ModalTitle() {
                let title = '';
                if(this.formState === 'create') {
                  title = 'Добавить учебное заведение'
              }
              if(this.formState === 'edit') {
                  title = 'Редактировать учебное заведение'
              }
              return title;
            },
        },
        data() {
            return {
                id:"",
                formState:'',
                cityForm: {
                    title:'',
                },
                dialogVisible:false,
                items:[],
                filters: [{
                    prop: 'title',
                    value: ''
                }],

            }
        },
        methods: {
            handleClose() {
                this.dialogVisible = false;
                this.formState = '';
                this.getItems();
            },
            handleEdit(row) {
                this.id = row.id;
                this.formState = 'edit';
                this.dialogVisible = true;
            },
            handleRemove(id) {
                this.$confirm('Это действие удалит Учебное заведение. Продолжить?', 'Удаление учебного заведения', {
                    confirmButtonText: 'Удалить',
                    cancelButtonText: 'Отмена',
                    type: 'warning'
                }).then(() => {
                    axios.post('/api/admin/edu-institution/' + id + '/remove')
                        .then((response) => {
                            this.$message({
                                type: 'success',
                                message: 'Учебное заведение удалено'
                            })
                            this.getItems();
                        });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Действие отменено '
                    });
                });

            },
            addCity() {
               this.formState = 'create';
               this.dialogVisible = true;
            },
            getItems() {
                axios.get('/api/admin/edu-institutions')
                    .then((response) => {
                        this.items = response.data;
                    })
            },
        },
        mounted() {
            this.getItems();
        }
    }
</script>
