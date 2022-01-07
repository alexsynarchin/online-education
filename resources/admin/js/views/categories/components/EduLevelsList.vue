<template>
    <section class="mt-3">
        <h4 class="mb-2">Уровни образования</h4>
        <el-form ref="levelForm" :model="level" class="d-flex align-items-start">
            <el-form-item  prop="title" style="margin-right: 15px; flex:1;">
                <el-input placeholder="Добавить уровень образования" v-model="level.title"></el-input>
            </el-form-item>
            <el-button icon="el-icon-plus" @click="storeItem(level)">Добавить</el-button>
        </el-form>
        <ul class="edu-levels-list">
            <li class="edu-levels-list__item" v-for="(item, index) in EduLevels">
                <el-form :model="item" v-if="editIndex === index" class="d-flex align-items-start" style="flex: 1">
                <el-form-item  prop="item_title" style="margin-right: 15px; flex:1;" >
                    <el-input placeholder="Добавить уровень образования" v-model="item.title"></el-input>
                </el-form-item>
                    <el-button   icon="el-icon-edit" type="primary" @click="updateItem(item)">Сохранить</el-button>
                </el-form>
                <template v-else>
                         <span class="edu-levels-list__show">
                    {{item.title}}
                </span>
                    <div>
                        <el-button  size="small" icon="el-icon-edit" type="primary" @click="editItem(item.id, index)">Редактировать</el-button>
                        <el-button size="small" icon="el-icon-delete" type="danger" @click="deleteItem(item.id)">Удалить</el-button>
                    </div>
                </template>
            </li>
        </ul>
    </section>
</template>
<script>
import deleteDialog from "../../../mixins/deleteDialog";
    export default {
        mixins:[deleteDialog],
        props: {
            id: {
                type:Number,
                required:true,
            }
        },
        data() {
            return {
                editIndex: null,
                level: {
                    parent_id: this.id,
                    title:'',
                    type: 'edu_level'
                },
                EduLevels: [],
            }
        },
        methods:{
            getLevels() {
                axios.get('/api/admin/category-types/' + 'edu_level', {params: {edu_type_id: this.id}})
                    .then((response) => {
                        this.EduLevels = response.data;

                    });
            },
            editItem(id, index) {
                this.editIndex = index;
            },
            async deleteItem(id) {

                const result = await this.deleteDialog('Удалить уровень образования. Все связанные курсы и уроки будут также удалены.')
                if(result) {
                    axios.post('/api/admin/category-type/'+ id + '/remove')
                    .then((response) => {
                        this.$message({
                            type: 'success',
                            message: 'Успешно удалено',
                        });
                        let index = this.EduLevels.findIndex(x => x.id === id);
                        this.EduLevels.splice(index, 1);
                    })
                    .catch((error)=> {

                    })
                }

            },
            storeItem(item) {
                axios.post('/api/admin/category-type/store', item)
                    .then((response) => {
                        this.$notify({
                            title: 'Добавлен уровень образования',
                            message: response.data.title + '.',
                            type: 'success',
                            duration:4000
                        });
                        this.level.title = ''
                        this.EduLevels.push(response.data);
                        this.handleClose();
                    })
            },
            updateItem(item) {
                axios.post('/api/admin/category-type/update', item)
                    .then((response) => {
                        this.$notify({
                            title: 'Уровень образования обновлен',
                            type: 'success',
                            duration:4000
                        });
                        this.editIndex = null;
                    })
                    .catch((error) => {

                    })
            }
        },
        mounted() {
            this.getLevels();
        }
    }
</script>
