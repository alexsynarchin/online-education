<template>
    <section class="profile-work-places">
        <div class="profile-work-places__heading" v-if="edit">
            <el-button icon="el-icon-plus" type="primary" @click="openModal" >
                Добавить место работы
            </el-button>
        </div>
        <div class="row">
            <div  class="col-md-6 mb-2"
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
                width="50%"
                :before-close="handleModalClose"
            >
            <el-form :model="workForm" :rules="rules" ref="workForm">
                <label class="el-form-item__label" style="display: block; float:none; text-align: left;">Регион</label>

                <el-form-item
                              class="profile-work-places__select-wrap"
                             >
                    <div class="d-flex">
                        <el-select class="profile-work-places__select"
                                   v-model="region_id"
                                   filterable
                                   @change="selectRegion(region_id)"
                                   placeholder="Выберите или найдите регион">
                            <el-option
                                v-for="item in regions"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        <el-button size="small" style="margin-left: 10px" icon="el-icon-plus" type="primary" @click="openRegionModal">Добавить</el-button>
                    </div>
                </el-form-item>
                <label class="el-form-item__label" style="display: block; float:none; text-align: left;">Город</label>
                <el-form-item
                    class="profile-work-places__select-wrap"
                    prop="city"
                >
                    <div class="d-flex">
                        <el-select class="profile-work-places__select"
                                   v-model="workForm.city"
                                   filterable
                                   @change="selectCity(workForm.city)"
                                   placeholder="Выберите или найдите город">
                            <el-option
                                v-for="item in cities"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        <el-button size="small" style="margin-left: 10px" icon="el-icon-plus" type="primary" @click="openCityModal">Добавить</el-button>
                    </div>
                </el-form-item>
                <el-form-item
                    class="profile-work-places__select-wrap"
                    :label="filters[0].label"
                    prop="edu_type"
                >
                        <el-select class="profile-work-places__select"
                                   v-model="workForm.edu_type"
                                   @change="selectEduType"
                                   :placeholder="filters[0].label">
                            <el-option
                                v-for="item in filters[0].options"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id">
                            </el-option>
                        </el-select>
                </el-form-item>
                <label class="el-form-item__label" style="display: block; float:none; text-align: left;">Учебное заведение</label>
                <el-form-item
                    class="profile-work-places__select-wrap"
                    prop="edu_institution"
                >
                    <div class="d-flex">
                        <el-select class="profile-work-places__select"
                                   v-model="workForm.edu_institution"
                                   @change="selectEduInstitution"
                                   filterable
                                   :placeholder="filters[1].label">
                            <el-option
                                v-for="item in filters[1].options"
                                :key="item.id"
                                :label="item.title"
                                :value="item.id">
                            </el-option>
                        </el-select>
                        <el-button size="small" style="margin-left: 10px"
                                   icon="el-icon-plus"
                                   type="primary"
                                   @click="openEduInstitutionModal">
                            Добавить
                        </el-button>
                    </div>
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
    <add-region ref="add_region" @addRegion="addRegion"></add-region>
    <add-city ref="add_city" :region_id="region_id" @addCity="addCity"></add-city>
    <add-edu-institution ref="add_edu_institution"
                         :city_id="workForm.city"
                         :type="workForm.edu_type"
                        @addEduInstitution="addEduInstitution"
    ></add-edu-institution>
    </section>
</template>
<script>
    import AddRegion from "../locations/AddRegion";
    import AddCity from "../locations/AddCity";
    import AddEduInstitution from "../locations/AddEduInstitution";
    export default {
        components: {
            AddRegion, AddCity, AddEduInstitution
        },
        props: {
            edit:{
                default:false,
            },
            regions: {
                type: Array,
            },
            edu_institutions: {
                type: Array,
                required:true,
            },
        },
        data() {
            return {
                modalVisible:false,
                region_id:null,
                cities:[],
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
                        type:'edu_institution',
                        label:'Выберите или найдите учебное заведение',
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
            handleModalClose() {
                this.workForm = {
                    main:false,
                    edu_type: null,
                    city: null,
                    edu_institution: null,
                }
                this.workItem.id = null;
                this.workItem.title = "";
                this.workItem.main = false;

                this.cities = [];
                this.filters[1].options = [];
                this.modalVisible = false;
            },
            addEduInstitution(data) {
                this.getEduInstitutions(this.workForm.edu_type);
                this.workItem.id = data.id;
                this.workForm.edu_institution = data.id;
                this.workItem.title = data.title;
            },
            openEduInstitutionModal() {
                this.$refs.add_edu_institution.modalVisible = true;
            },
            selectCity(city_id) {
                this.workForm.edu_institution = null;
                this.filters[1].value = null;
                this.filters[1].options = [];
                if(this.workForm.edu_type) {
                    this.getEduInstitutions(this.workForm.edu_type);
                }
            },
            openCityModal() {
                this.$refs.add_city.openModal(this.region_id);
            },
            addCity(city_id) {
                this.workForm.city = city_id;
                this.workForm.edu_institution = null;
                this.filters[1].value = null;
                if(this.workForm.edu_type) {
                    this.getEduInstitutions(this.workForm.edu_type);
                } else {
                    this.filters[1].options = [];
                }
                this.getCities(this.region_id);
            },
            openRegionModal() {
                this.$refs.add_region.modalVisible = true;
            },
            addRegion(region_id) {
                this.region_id = region_id;
                this.getRegions();
                this.getCities(region_id);
                this.workForm.city = null;
                this.workForm.edu_institution = null;
                this.filters[1].value = null;
                this.filters[1].options = [];
            },
            getRegions(){
                this.$emit('getRegions');
            },
            selectRegion(region_id) {
                this.workForm.city = null;
                this.workForm.edu_institution = null;
                this.filters[1].options = [];
                this.getCities(region_id)
            },
            getCities(region_id) {
                axios.get('/api/cities', {params:{region_id:region_id}})
                    .then((response) => {
                        this.cities = response.data;
                    })
            },

            openModal() {
                if(this.edu_institutions.length < 4 ) {
                    this.modalVisible = true;
                } else {
                    this.$notify.error({
                        title: 'Количество мест работы не может быть больше 4',
                    });

                }

            },
            selectEduType() {
                this.workForm.edu_institution = null;
                if(this.workForm.city) {
                    this.getEduInstitutions(this.workForm.edu_type);
                } else {
                    this.filters[1].options = [];
                }
            },
            selectEduInstitution() {
                this.workItem.id = this.workForm.edu_institution;
                let index = this.filters[1].options.findIndex( x => x.id === this.workForm.edu_institution);
                this.workItem.title = this.filters[1].options[index].title;
            },
            deleteWorkPlace(index) {
                this.edu_institutions.splice(index, 1);
            },
            getEduInstitutions(type) {
                axios.get('/api/edu-institutions', {params:{city_id:this.workForm.city, type:type}})
                    .then((response) => {
                        this.filters[1].options = response.data;
                    })
            },
            getFilterData(type) {
                axios.get('/api/search-teacher/filter', {params:
                        {
                            type:type,
                            edu_type: this.filters[0].value,
                            city: this.workForm.city
                        }})
                    .then((response) => {
                        this.filters[1].options = response.data;
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
                      this.edu_institutions.push({id:this.workItem.id, main:this.workItem.main, title:this.workItem.title});
                        this.workForm = {
                            main:false,
                            edu_type: null,
                            city: null,
                            edu_institution: null,
                        }
                        this.workItem.id = null;
                        this.workItem.title = "";
                        this.workItem.main = false;

                        this.cities = [];
                        this.filters[1].options = [];
                      this.modalVisible = false;
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },

        },
        mounted() {

        }
    }
</script>
