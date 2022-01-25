<template>
    <section class="subject-cats row">
        <div class="col-md-6">
            <el-row type="flex">
                <el-col :span="12">
                    <el-button type="success"
                               icon="el-icon-plus"
                               class="mb-3"
                               @click.prevent="addDirection"
                    >Добавить направление</el-button>
                </el-col>
                <el-col :span="12">
                    <el-input
                        v-model="filters[0].value"
                        size="large"
                        width="100%"
                        placeholder="Введите название предмета"/>
                </el-col>
            </el-row>
            <data-tables :data="subjects"  :filters="filters">
                <el-table-column
                    type="index"
                >
                </el-table-column>
                <el-table-column
                    prop="title"

                    width="250"
                    sortable
                >
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
        </div>
        <el-dialog
            v-if="showModal"
            :title="modalTitle"
            :visible.sync="showModal"
            width="50%"
            :before-close="handleClose">
            <el-form ref="form" :model="subjectItem">
                <el-form-item label="Заголовок направления" prop="title">
                    <el-input v-model="subjectItem.title"></el-input>
                </el-form-item>
                <speciality-list v-if="subjectItem.id" :parent_id="subjectItem.id"></speciality-list>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showModal = false">Закрыть</el-button>
                <el-button type="primary" @click="updateItem" v-if="subjectItem.id">Сохранить</el-button>
                <el-button type="primary" @click="storeSubject" v-else>Добавить</el-button>
            </span>
        </el-dialog>
    </section>
</template>
<script>
import deleteDialog from "../../../mixins/deleteDialog";
import specialityList from "./speciality";
export default {
    mixins:[deleteDialog],
    components:{
        specialityList,
    },
    computed:{},
    mounted(){
        this.getDirections();
    },
    data(){
        return{
            filters: [{
                prop: 'title',
                value: ''
            }],
            subjects:[],
            search: '',
            subjectItem: {},
            showModal:false,
            modalTitle: '',
        }
    },
    methods:{
        addDirection() {
            this.modalTitle = 'Новое направление';
            this.subjectItem.type = 'specialty';
            this.showModal = true;
        },
        storeSubject() {
            axios.post('/api/admin/category-type/store', this.subjectItem)
                .then((response) => {
                    this.$notify({
                        title: 'Добавлено направление',
                        message: response.data.title + '.',
                        type: 'success',
                        duration:4000
                    });
                    this.subjects.push(response.data);
                    this.handleClose();
                })
        },
        getDirections(){
            axios.get('/api/admin/category-types/specialty')
                .then((response)=>{
                    this.subjects = response.data;
                })
        },
        handleEdit(index, row) {
            this.modalTitle = 'Редактировать направление';
            this.getSubjectItem(row.id, 'specialty');
        },
        updateItem() {
            axios.post('/api/admin/category-type/update', this.subjectItem)
                .then((response) => {
                    this.$notify({
                        title: 'Обновлено',
                        message: response.data.title + '.',
                        type: 'success',
                        duration:4000
                    });
                    let index = this.subjects.findIndex(x => x.id === response.data.id);
                    this.subjects[index].title = response.data.title;
                    this.handleClose();
                })
                .catch((error) => {

                })
        },
        handleClose() {
            this.subjectItem = {};
            this.modalTitle = '';
            this.showModal = false;
        },
        getSubjectItem(id, type) {
            axios.get('/api/admin/category-types/' + type + '/' + id)
                .then((response) => {
                    this.subjectItem = response.data;
                    this.showModal = true;
                })
        },
        async handleDelete(id) {
            const result = await this.deleteDialog('Удалить уровень образования. Все связанные курсы и уроки будут также удалены.')
            if(result) {
                axios.post('/api/admin/category-type/'+ id + '/remove')
                    .then((response) => {
                        this.$message({
                            type: 'success',
                            message: 'Успешно удалено',
                        });
                        let index = this.subjects.findIndex(x => x.id === id);
                        this.subjects.splice(index, 1);
                    })
                    .catch((error)=> {

                    })
            }
        },

    }
}
</script>
