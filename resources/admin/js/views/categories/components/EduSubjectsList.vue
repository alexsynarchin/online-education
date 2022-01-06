<template>
    <section class="subject-cats row">
        <div class="col-md-6">
            <el-row type="flex">
                <el-col :span="12">
                    <el-button type="success"
                               icon="el-icon-plus"
                               class="mb-3"
                               @click.prevent="$modal.show('SubjectModal',{ actionState:'add',title:'Новый предмет'})"
                    >Добавить Предмет</el-button>
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
            :title="modalTitle"
            :visible.sync="showModal"
            width="50%"
            :before-close="handleClose">
            <el-form ref="form" :model="subjectItem">
                <el-form-item label="Заголовок типа образования" prop="title">
                    <el-input v-model="subjectItem.title"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showModal = false">Закрыть</el-button>
                <el-button type="primary" @click="updateItem">Сохранить</el-button>
            </span>
        </el-dialog>
    </section>
</template>
<script>
import deleteDialog from "../../../mixins/deleteDialog";
export default {
    mixins:[deleteDialog],
    components:{

    },
    computed:{},
    mounted(){
        this.getSubjects();
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
        getSubjects(){
            axios.get('/api/admin/category-types/subject')
                .then((response)=>{
                    this.subjects = response.data;
                })
        },
        handleEdit(index, row) {
            this.modalTitle = 'Редактировать предмет';
            this.getSubjectItem(row.id, 'subject');
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
