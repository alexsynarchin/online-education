<template>
    <section class="page">
        <div class="page-heading d-flex align-items-center justify-content-between mb-3">
            <h1 class="page-title mb-0">Модераторы</h1>
            <el-button type="success" icon="el-icon-plus" @click="moderatorModalOpen('create')">Добавить</el-button>
        </div>
        <el-row type="flex" class="mb-3">
            <el-col :span="8">
                <el-input
                    v-model="filters[0].value"
                    size="large"
                    width="100%"
                    placeholder="Поиск: Имя, Фамилия или Отчество"/>
            </el-col>
        </el-row>
        <data-tables :data="moderators"  :filters="filters">
            <el-table-column
                type="index"
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
                label="Действия"
            >

                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="handleEdit(scope.$index, scope.row)">Редактировать</el-button>

                </template>
            </el-table-column>
        </data-tables>
        <el-dialog
            :visible.sync="moderatorModal"
            width="60%"
            :title="moderatorModalTitle"
            @closed = "resetForm('moderatorForm')"
        >
            <el-tabs type="card" >
                <el-tab-pane label="Основная информация">
                    <el-form :model="moderatorForm" ref="moderatorForm" :rules="moderator_rules">
                        <el-row type="flex" :gutter="10">
                            <el-col :span="12">
                                <el-form-item prop="email" label="E-mail" :error="errors.get('email')">
                                    <el-input v-model="moderatorForm.email" placeholder="Электронная почта"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="name" label="Имя">
                                    <el-input v-model="moderatorForm.name" placeholder="Имя"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row type="flex" :gutter="10">
                            <el-col :span="12">
                                <el-form-item prop="surname" label="Фамилия">
                                    <el-input v-model="moderatorForm.surname" placeholder="Фамилия"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="last_name" label="Отчество">
                                    <el-input v-model="moderatorForm.last_name" placeholder="Отчество"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row type="flex" :gutter="10">
                            <el-col :span="12">
                                <el-form-item prop="password" label="Пароль" :error="errors.get('password')">
                                    <el-input v-model="moderatorForm.password" placeholder="Введите пароль" show-password></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="password_confirmation" label="Подтверждение пароля">
                                    <el-input v-model="moderatorForm.password_confirmation" placeholder="Повторите пароль" show-password></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <div class="text-center">
                            <el-button type="primary" @click.prevent="newModerator('moderatorForm')" v-if="moderatorModalStatus === 'create'">Добавить</el-button>
                            <el-button type="primary" @click.prevent="updateModerator('moderatorForm')" v-if="moderatorModalStatus === 'update'">
                                Обновить
                            </el-button>
                            <el-button type="" @click.prevent="moderatorModal=false">Отменить</el-button>
                        </div>
                    </el-form>
                </el-tab-pane>
                <!-- <el-tab-pane label="Права доступа">

                 </el-tab-pane>-->
            </el-tabs>
        </el-dialog>
    </section>

</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
export default {
    computed:{
        moderatorModalTitle:function () {
            if(this.moderatorModalStatus === 'create') {
                return 'Новый модератор';
            }
            if(this.moderatorModalStatus === 'update') {
                return 'Обновление данных модератора';
            }
        },

    },
    data() {
        return {
            moderatorForm: {
                email:"",
                name:"",
                surname:"",
                last_name:"",
                password:"",
                password_confirmation:"",
                id:null,
            },
            moderator_rules:{
                email:[
                    {required:true,message:'Введите электронную почту'}
                ],
                name:[
                    {required:true,message:'Введите имя модератора'}
                ],
                surname:[
                    {required:true,message:'Введите фамилию модератора'}
                ],
                password:[
                    {required:true,message:'Введите пароль для модератора'}
                ],
                password_confirmation:[
                    {required:true,message:'Введите подтверждения пароля'}
                ],
            },
            moderatorModal:false,
            moderatorModalStatus:"",
            moderators: [],
            filters: [
                {
                    prop: ['name', 'surname', 'last_name'],
                    value: ""
                }
            ],
            errors: new Errors(),
        }
    },
    methods: {
        moderatorModalOpen(status) {
            this.moderatorModalStatus = status;
            this.moderatorModal = true;
            if(status === 'create') {
                this.moderator_rules.password[0].required = true;
                this.moderator_rules.password_confirmation[0].required = true;
            } else {
                this.moderator_rules.password[0].required = false;
                this.moderator_rules.password_confirmation[0].required = false;
            }
        },
        getModerators() {
            axios.get('/api/admin/users', {params: {type:'admin'}})
                .then((response) => {
                    this.moderators = response.data;
                })
        },
        handleEdit(index, row) {
            this.moderatorModalOpen('update');
            this.moderatorForm.id = row.id;
            this.moderatorForm.email = row.email;
            this.moderatorForm.name = row.name;
            this.moderatorForm.surname = row.surname;
            this.moderatorForm.last_name = row.last_name;
        },
        updateModerator(formName) {

        },
        newModerator(formName) {
            this.$refs[formName].validate((valid) => {
                if(valid) {
                    axios.post('/api/admin/create-moderator',this.moderatorForm)
                        .then((response) => {
                            this.moderatorModal = false;

                            this.$message({
                                message: response.data,
                                type: 'success'
                            });
                            this.getModerators();
                        })
                        .catch((error) => {
                            this.errors.record(error.response.data.errors);
                        })
                } else {
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            if(this.moderatorModalStatus === 'update') {
                this.moderatorForm.id = null;
                this.moderatorForm.email = "";
                this.moderatorForm.name = "";
                this.moderatorForm.surname = "";
                this.moderatorForm.last_name = "";
            }
        }
    },
    mounted() {
        this.getModerators();
    }
}
</script>
