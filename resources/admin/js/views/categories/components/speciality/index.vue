<template>
    <section>
        <div class="mb-3">
            <el-button type="success" icon="el-icon-plus" @click="addItem">Добавить специальность</el-button>
        </div>
        <ul class="edu-cat-list">
            <li class="edu-cat-list__item" v-for="(item, index) in items">
                <h4 class="edu-cat-list__title">
                    {{item.title}}
                </h4>
                <el-tag v-if="item.edu_type_id === 2">Среднее образование</el-tag>
                <el-tag v-if="item.edu_type_id === 3">Высшее образование</el-tag>
                <el-tag v-if="!item.edu_type_id">Среднее и высшее образование</el-tag>
                <div>
                    <el-button type="primary" size="medium" circle icon="el-icon-edit" @click.prevent="handleEdit(item.id)"></el-button>
                    <el-button type="danger" size="medium" circle icon="el-icon-delete" @click.prevent="handleDelete(item.id)"></el-button>
                </div>
            </li>
        </ul>
        <el-dialog
            v-if="showModal"
            :title="modalTitle"
            :visible.sync="showModal"
            width="50%"
            append-to-body
            :before-close="handleClose">
            <el-form ref="form" label-position="top" :model="categoryItem">
                <div class="row">
                    <el-form-item class="col-md-6" label="Заголовок направления" prop="title">
                        <el-input v-model="categoryItem.title"></el-input>
                    </el-form-item>
                    <el-form-item class="col-md-6" label="Тип образования" prop="edu_type_id">
                        <el-select v-model="categoryItem.edu_type_id" placeholder="Выбрать тип образования">
                            <el-option
                                v-for="item in edu_types"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showModal = false">Закрыть</el-button>
                <el-button type="primary" @click="updateItem" v-if="categoryItem.id">Сохранить</el-button>
                <el-button type="primary" @click="storeItem" v-else>Добавить</el-button>
            </span>
        </el-dialog>
    </section>
</template>
<script>
import deleteDialog from "../../../../mixins/deleteDialog";
    export default {
        mixins:[deleteDialog],
        props: {
            parent_id: {
                type: Number,
            }
        },
        data() {
            return {
                items:[],
                categoryItem: {
                    parent_id:this.parent_id,
                },
                showModal:false,
                modalTitle:'',
                edu_types: [
                    {
                        label:'Среднее образование ',
                        value:2,
                    },
                    {
                        label:'Высшее образование',
                        value:3,
                    },
                ],
            }
        },
        methods: {
            addItem() {
                this.modalTitle = 'Новое направление';
                this.categoryItem.type = 'specialty';
                this.showModal = true;
            },
            handleEdit(id) {
                this.modalTitle = 'Редактировать специальность';
                this.getSubjectItem(id, 'specialty');
            },
            getItems() {
                axios.get('/api/admin/category-types/specialty', {params: {parent_id:this.parent_id}})
                    .then((response)=>{
                        this.items = response.data;
                    })
            },
            storeItem() {
                axios.post('/api/admin/category-type/store', this.categoryItem)
                    .then((response) => {
                        this.$notify({
                            title: 'Добавлена специальность',
                            message: response.data.title + '.',
                            type: 'success',
                            duration:4000
                        });
                        this.items.push(response.data);
                        this.handleClose();
                    })
            },
            handleClose() {
                this.categoryItem = {
                    parent_id: this.parent_id
                };
                this.modalTitle = '';
                this.showModal = false;
            },
            updateItem() {
                axios.post('/api/admin/category-type/update', this.categoryItem)
                    .then((response) => {
                        this.$notify({
                            title: 'Обновлено',
                            message: response.data.title + '.',
                            type: 'success',
                            duration:4000
                        });
                        let index = this.items.findIndex(x => x.id === response.data.id);
                        this.items[index].title = response.data.title;
                        this.handleClose();
                    })
                    .catch((error) => {

                    })
            },
            getSubjectItem(id, type) {
                axios.get('/api/admin/category-types/' + type + '/' + id)
                    .then((response) => {
                        this.categoryItem = response.data;
                        this.showModal = true;
                    })
            },
            async handleDelete(id) {
                const result = await this.deleteDialog('Удалить специальность?')
                if(result) {
                    axios.post('/api/admin/category-type/'+ id + '/remove')
                        .then((response) => {
                            this.$message({
                                type: 'success',
                                message: 'Успешно удалено',
                            });
                            let index = this.items.findIndex(x => x.id === id);
                            this.items.splice(index, 1);
                        })
                        .catch((error)=> {

                        })
                }
            },
        },
        mounted() {
            this.getItems();
        }
    }
</script>
