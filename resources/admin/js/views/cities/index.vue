<template>
    <section>
        <h1 class="page-title">
            Города и учебные заведения
        </h1>
        <el-row type="flex" class="mb-3">
            <el-col :span="12">
                <el-button type="success" icon="el-icon-plus" @click.prevent="addCity">Добавить город</el-button>
            </el-col>
            <el-col :span="12">
                <el-input
                    v-model="filters[0].value"
                    size="large"
                    width="100%"
                    placeholder="Название города"/>
            </el-col>
        </el-row>
        <data-tables :data="cities"  :filters="filters">
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
                label="Действия"
            >
                <el-button
                    size="mini"
                    type="primary"
                    @click="handleEdit(scope.$index, scope.row)">Редактировать</el-button>
                <el-button
                    size="mini"
                    type="danger"
                    @click="handleRemove(scope.$index, scope.row)">Удалить</el-button>
            </el-table-column>
        </data-tables>
        <el-dialog
            :title="ModalTitle"
            :visible.sync="dialogVisible"
            width="50%"
            :before-close="handleClose">
            <create v-if="formState === 'create'" @close="handleClose"></create>
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
                  title = 'Добавить город'
              }
              if(this.formState === 'edit') {
                  title = 'Редактировать'
              }
              return title;
            },
        },
        data() {
            return {
                formState:'',
                cityForm: {
                    title:'',
                },
                dialogVisible:false,
                cities:[],
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
            },
            handleEdit() {

            },
            handleRemove() {

            },
            addCity() {
                console.log('test');
               this.formState = 'create';
                this.dialogVisible = true;
            },
            getCities() {
                axios.get('/api/admin/cities')
                    .then((response) => {
                        this.cities = response.data;
                    })
            },
        },
        mounted() {
            this.getCities();
        }
    }
</script>
