<template>
    <section class="items-list">
        <h1>Блог</h1>
        <el-row type="flex" class="mb-3">
            <el-col :span="12">
                <el-button type="success" icon="el-icon-plus" @click.prevent="newItem">Добавить Страницу</el-button>
            </el-col>
            <el-col :span="12">
                <el-input
                    v-model="filters[0].value"
                    size="large"
                    width="100%"
                    placeholder="Название"/>
            </el-col>
        </el-row>
        <data-tables :data="pages"  :filters="filters">
            <el-table-column
                type="index"
            >
            </el-table-column>
            <el-table-column
                label="Название"
                sortable
            >
                <template slot-scope="scope">
                    <div style="word-break: normal">
                        {{scope.row.title}}
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                label="url"
                sortable

            >
                <template slot-scope="scope">
                    {{scope.row.slug}}
                </template>
            </el-table-column>
            <el-table-column
                label="Действия"
            >

                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="handleEdit(scope.$index, scope.row)">Редактировать</el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row)">Удалить</el-button>
                </template>
            </el-table-column>
        </data-tables>

        <el-dialog
            :title="ModalTitle"
            :visible.sync="pageModal"
            width="80%"
        >
            <create-page
                v-if="ModalStatus === 'new' && pageModal"
                @closeModal="closeModal"
            ></create-page>
            <edit-page
                :id="id"
                @closeModal="closeModal"
                v-if="ModalStatus === 'edit' && pageModal"
            >
            </edit-page>
        </el-dialog>
    </section>
</template>
<script>
    import create from "./create";
    import edit from "./edit";
    export default {

        components: {
            'CreatePage': create,
            'editPage': edit,
        },
        methods:{
            handleEdit(index, row){
                this.ModalStatus = 'edit';
                this.pageModal = true;
                this.id = row.id;

            },
            handleDelete(index,row) {
                axios.post('/api/admin/article/'+ row.id + '/remove')
                    .then((response) => {
                        this.pages.splice(index, 1);
                    })
            },
            newItem() {
                this.ModalStatus = 'new',
                    this.pageModal = true;
            },
            closeModal(value) {
                this.pageModal = false;
                if(value === 'submit') {
                    this.getPages();
                }
            },
            getPages()
            {
                axios.get('/api/admin/articles')
                    .then((response) => {
                        this.pages = response.data
                    })
            }

        },
        data(){
            return{
                id:null,
                pages:[],
                pageModal:false,
                ModalTitle:'Добавить статическую страницу',
                ModalStatus:'',
                filters: [{
                    prop: 'name',
                    value: ''
                }],
            }
        },
        mounted() {
            this.getPages();
        }
    }
</script>
