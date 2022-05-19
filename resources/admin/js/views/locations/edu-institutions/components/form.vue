<template>
    <el-form :model="cityForm"  ref="cityForm" label-position="top" >
        <el-form-item :error="errors.get('region.id')" class="col-md-4" label="Регион">
            <el-select v-model="cityForm.region.id"
                       placeholder="Выберите регион"
                       style="width: 100%;"
                       @change="selectRegion"
            >
                <el-option
                    v-for="item in regions"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item :error="errors.get('city_id')" class="col-md-4" label="Город">
            <el-select v-model="cityForm.city_id"
                       placeholder="Выберите город"
                       style="width: 100%;"
            >
                <el-option
                    v-for="item in cities"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item :error="errors.get('type')" class="col-md-4" label="Тип учебного заведения">
            <el-select v-model="cityForm.type"
                       placeholder="Выберите тип учебного заведения"
                       style="width: 100%;"
            >
                <el-option
                    v-for="item in types"
                    :key="item.slug"
                    :label="item.title"
                    :value="item.slug">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="Название учебного заведения" prop="title" :error="errors.get('title')">
            <el-input v-model="cityForm.title" ></el-input>
        </el-form-item>
        <el-button type="success" @click="saveForm">Сохранить</el-button>
        <el-button type="default" @click="closeModal">Отмена</el-button>
    </el-form>
</template>
<script>
    import { Errors } from  '@/common/js/services/errors.js';
    export default {
        props: {
            action: {
                type: String
            },
            cityForm: {
                type: Object,
            }
        },
        data() {
            return {
                regions:[],
                cities:[],
                types: [
                    {
                        slug:  "preschool",
                        title: "Дошкольное",
                    },
                    {
                        slug: "university",
                        title: "Высшее",
                    },
                    {
                        slug:"secondary_special",
                        title: "Средне-специальное",
                    },
                    {
                        slug: "school",
                        title: "Школа",
                    },


                ],
                errors: new Errors(),
            }
        },
        methods: {
            selectRegion(id) {
                this.getCities(id);
            },
            closeModal() {
                this.$emit('close');
            },
            saveForm() {
              axios.post(this.action, this.cityForm)
                  .then((response)=>{
                      this.$notify({
                          title: 'Информация  сохранена',
                          type: 'success'
                      });
                      this.closeModal();
                  })
                  .catch((error)=>{
                      this.errors.record(error.response.data.errors);
                  })
            },
            getRegions() {
                axios.get('/api/admin/regions')
                    .then((response) => {
                        this.regions = response.data;
                    })
            },
            getCities(id) {
                axios.get('/api/admin/cities', {params: {region_id: id}})
                    .then((response) => {
                        this.cities = response.data;
                    })
            },
        },
        mounted() {
            this.getRegions();
            if(this.cityForm.city_id) {
                this.getCities(this.cityForm.region.id)
            }
        }
    }
</script>
