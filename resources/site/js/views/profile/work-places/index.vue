<template>
    <section class="profile-work-places">
        <div class="profile-work-places__heading" v-if="edit">
            <el-button icon="el-icon-plus" type="primary" @click="openModal" >
                Добавить место работы
            </el-button>
        </div>
        <div class="row">
            <div  class="col-md-4 mb-2"
                  :key="index"
                  v-for="(item, index) in edu_institutions">
                <el-card shadow="always" style="height: 100%">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="margin-right: 10px">
                            {{item.title}}
                        </h5>
                        <el-button size="small" type="danger" icon="el-icon-delete" @click="deleteWorkPlace(index)" v-if="edit"></el-button>
                    </div>
                    <el-tag class="mt-2" type="success" v-if="item.main">Основное место работы</el-tag>
                </el-card>
            </div>
        </div>
        <el-dialog
            title="Новое место работы"
            :visible.sync="modalVisible"
            width="30%"
        >
        <el-form :model="workForm" :rules="rules" ref="workForm">

            <el-form-item :label="item.label"
                          class="profile-work-places__select-wrap"
                          :prop="item.type"
                          v-for="(item, index) in filters"
                          :key="index">
                <el-select class="profile-work-places__select"
                           v-model="item.value"
                           @change="selectFilter(item.type, item.value)"
                           :placeholder="item.label">
                    <el-option
                        v-for="item in item.options"
                        :key="item.id"
                        :label="item.title"
                        :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-checkbox v-model="workForm.main">Основное место работы</el-checkbox>
            </el-form-item>
        </el-form>
    <span slot="footer" class="dialog-footer">
    <el-button type="success" @click="addWorkPlace('workForm')">Добавить</el-button>
    <el-button type="default" @click="modalVisible = false">Отменить</el-button>
  </span>
        </el-dialog>
    </section>

</template>
<script>
    export default {
        props: {
            edit:{
                default:false,
            },
            edu_institutions: {
                type: Array,
                required:true,
            },
        },
        data() {
            return {
                modalVisible:false,
                workItem : {
                    id: null,
                    title: null,
                    main:false,
                },
                filters: [
                    {
                        type:'edu_type',
                        label:'Выберите тип учебного заведения:',
                        options: [
                            {
                                id:'school',
                                slug:'school',
                                title:'Школа'
                            },
                            {
                                id:'university',
                                slug:'university',
                                title:'ВУЗ'
                            }
                        ],
                        value:null,
                    },
                    {
                        type:'city',
                        label:'Выберите ваш город:',
                        options: [],
                        value:null,
                    },
                    {
                        type:'edu_institution',
                        label:'Выберите учебное заведение:',
                        options: [],
                        value:null,
                    },
                ],
                workForm : {
                    main:false,
                    edu_type: null,
                    city: null,
                    edu_institution: null,
                },
                rules: {
                    edu_type: [
                        {required:true, message: "Выберите тип учебного заведения"}
                    ],
                    city: [
                        {required:true, message: "Выберите город"}
                    ],
                    edu_institution: [
                        {
                            required:true, message: "Выберите учебное заведение"
                        }
                    ]
                },
            }
        },
        methods: {
            openModal() {
                this.modalVisible = true;
            },
             selectFilter(type, value) {
                this.workForm.edu_type = this.filters[0].value;
                 this.workForm.city = this.filters[1].value;
                 this.workForm.edu_institution = this.filters[2].value;

                 if(type != 'edu_institution' && this.filters[0].value && this.filters[1].value) {
                     this.filters[2].value = null;
                     this.filters[2].options = [];
                     this.getFilterData('edu_institution');
                 } else {
                     this.workItem.id = value;
                     let index = this.filters[2].options.findIndex( x => x.id === value);
                     this.workItem.title = this.filters[2].options[index].title;
                 }
             },
            deleteWorkPlace(index) {
                this.edu_institutions.splice(index, 1);
            },
            getFilterData(type) {
                axios.get('/api/search-teacher/filter', {params:
                        {
                            type:type,
                            edu_type: this.filters[0].value,
                            city: this.filters[1].value
                        }})
                    .then((response) => {
                        if(type === 'city') {
                            this.filters[1].options = response.data;
                        } else if(type === 'edu_institution') {
                            this.filters[2].options = response.data;
                        }
                    })
            },
            addWorkPlace(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.workItem.main = this.workForm.main;
                        if(this.workForm.main) {
                            this.edu_institutions.forEach(function(item, i, arr) {
                               item.main = false;
                            });
                        }
                        this.workForm.main = false;
                      this.edu_institutions.push(this.workItem);
                      this.modalVisible = false;
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        },
        mounted() {
            this.getFilterData('city');
        }
    }
</script>
