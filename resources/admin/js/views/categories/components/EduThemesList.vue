<template>
    <section>
        <el-row type="flex">
            <el-col :span="12">
                <el-button type="success"
                           icon="el-icon-plus"
                           class="mb-3"
                           @click.prevent="addTheme"
                >Добавить Тему</el-button>
            </el-col>
            <el-col :span="12">
                <el-input
                    v-model="filters[0].value"
                    size="large"
                    width="100%"
                    placeholder="Введите название темы курса"/>
            </el-col>
        </el-row>
        <data-tables :data="themes"  :filters="filters">
            <el-table-column
                type="index"
            >
            </el-table-column>
            <el-table-column
                prop="title"
                label="Название"
                width="250"
                sortable
            >
            </el-table-column>
            <el-table-column align="center" label="Предмет" prop="subject"  sortable>

                <template slot-scope="scope">
                  {{scope.row.parent.title}}
                </template>
            </el-table-column>
            <el-table-column align="center" label="Действия">

                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        @click="handleEdit(scope.$index, scope.row)">Редактировать</el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.row.id)">Удалить</el-button>
                </template>
            </el-table-column>
        </data-tables>
        <el-dialog
            v-if="showModal"
            :title="modalTitle"
            :visible.sync="showModal"
            width="50%"
            :before-close="handleClose">
            <el-form ref="form" :model="themeItem" label-position="top">
                <el-form-item label="Выберите предмет" prop="subject" :error="errors.get('parent_id')">
                    <el-select filterable v-model="themeItem.parent_id" placeholder="Выберите предмет">
                        <el-option
                            v-for="item in subjects"
                            :key="item.id"
                            :label="item.title"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Заголовок темы" prop="title" :error="errors.get('title')">
                    <el-input v-model="themeItem.title"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showModal = false">Закрыть</el-button>
                <el-button type="primary" @click="updateItem" v-if="themeItem.id">Сохранить</el-button>
                <el-button type="primary" @click="storeItem" v-else>Добавить</el-button>
            </span>
        </el-dialog>
    </section>
</template>
<script>
import DeleteDialog from "../../../mixins/deleteDialog";
import { Errors } from  '@/common/js/services/errors.js';
import deleteDialog from "../../../mixins/deleteDialog";
    export default {
        mixins:[deleteDialog],
        data() {
            return {
                themes: [],
                filters: [{
                    prop: 'title',
                    value: ''
                }],
                themeItem: {},
                showModal:false,
                modalTitle: '',
                subjects: {},
                errors: new Errors(),
            }
        },
        methods: {
            addTheme() {
                this.modalTitle = 'Новая тема курса';
                this.themeItem.type = 'theme';
                this.showModal = true;
            },
            handleEdit(index, row) {
                this.modalTitle = 'Редактировать тему курса';
                this.themeItem = row;
                this.showModal = true;
            },
            async handleDelete(id) {
                const result = await this.deleteDialog('Удалить тему курса.')
                if(result) {
                    axios.post('/api/admin/category-type/'+ id + '/remove')
                        .then((response) => {
                            this.$message({
                                type: 'success',
                                message: 'Успешно удалено',
                            });
                            let index = this.themes.findIndex(x => x.id === id);
                            this.themes.splice(index, 1);
                        })
                        .catch((error)=> {

                        })
                }
            },
            handleClose() {
                this.showModal=false;
                this.themeItem = {};
                this.modalTitle = '';
            },
            updateItem() {
                axios.post('/api/admin/category-type/update', this.themeItem)
                    .then((response) => {
                        this.$notify({
                            title: 'Обновлено',
                            message: response.data.title + '.',
                            type: 'success',
                            duration:4000
                        });
                        let index = this.themes.findIndex(x => x.id === response.data.id);
                        this.themes[index].title = response.data.title;
                        this.themes[index].parent_id = this.themeItem.parent_id;
                        this.getThemes();
                        this.handleClose();
                    })
                    .catch((error) => {

                    })
            },
            storeItem() {
                axios.post('/api/admin/category-type/store', this.themeItem)
                    .then((response) => {
                        this.$notify({
                            title: 'Добавлена тема курса',
                            message: response.data.title + '.',
                            type: 'success',
                            duration:4000
                        });
                        this.getThemes();
                        this.handleClose();
                    })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
            },
            getSubjects() {
                axios.get('/api/admin/category-types/subject')
                    .then((response)=>{
                        this.subjects = response.data;
                    })
            },
            getThemes() {
                axios.get('/api/admin/category-types/theme/list')
                    .then((response)=>{
                        this.themes = response.data;
                    })
            },
        },
        mounted() {
            this.getThemes();
            this.getSubjects();
        }
    }
</script>
