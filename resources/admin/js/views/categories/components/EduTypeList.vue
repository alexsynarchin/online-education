<template>
    <section class="edu-types container">
        <div class="row">
            <div class="col-md-6 mb-4"  v-for="item in EduList" v-bind:key="item.id" >
                <el-card shadow="hover" class="edu-type-item" style="height: 100%">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="edu-type-item__title text-center">{{item.title}}</h5>
                        <el-button icon="el-icon-edit" type="primary" @click="editItem(item.id)">Редактировать</el-button>
                    </div>
                    <edu-levels-list :id="item.id"></edu-levels-list>
                </el-card>
            </div>
        </div>
        <el-dialog
            title="Редактировать тип образования"
            :visible.sync="showModal"
            width="50%"
            :before-close="handleClose">
            <el-form ref="form" :model="EduTypeItem">
                <el-form-item label="Заголовок типа образования" prop="title">
                    <el-input v-model="EduTypeItem.title"></el-input>
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
import EduLevelsList from "./EduLevelsList";
    export default {
        mounted(){
            this.getEduList()
        },
        components: {
            EduLevelsList,
        },
        computed:{

        },
        data(){
            return{
                EduTypeItem: {},
                EduList:[],
                showModal:false,
            }
        },
        methods:{
            handleClose() {
            this.EduTypeItem = {};
            this.showModal = false;
            },
            editItem(id) {
                this.getEduItem(id, 'edu_type');
                this.showModal = true;
            },
            updateItem() {
                axios.post('/api/admin/category-type/update', this.EduTypeItem)
                .then((response) => {
                    this.$notify({
                        title: 'Обновлено',
                        message: response.data.title + '.',
                        type: 'success',
                        duration:4000
                    });
                   let index = this.EduList.findIndex(x => x.id === response.data.id);
                    this.EduList[index].title = response.data.title;
                    this.handleClose();
                })
                .catch((error) => {

                })
            },
            getEduItem(id, type) {
                axios.get('/api/admin/category-types/' + type + '/' + id)
                .then((response) => {
                    this.EduTypeItem = response.data;
                })
            },
            getEduList(){

                axios.get('/api/admin/category-types/' + 'edu_type')
                    .then((response) => {
                        console.log(response.data);
                        this.EduList = response.data;

                    });
            },
        }
    }
</script>
