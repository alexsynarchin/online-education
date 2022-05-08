<template>
    <el-form :model="cityForm"  ref="cityForm" label-position="top" >
        <el-form-item :error="errors.get('region_id')" class="col-md-4" label="Регион">
            <el-select v-model="cityForm.region_id"
                       placeholder="Выберите регион"
                       style="width: 100%;"
            >
                <el-option
                    v-for="item in regions"
                    :key="item.id"
                    :label="item.title"
                    :value="item.id">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="Название города" prop="title" :error="errors.get('title')">
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
                errors: new Errors(),
            }
        },
        methods: {
            getRegions() {
                axios.get('/api/admin/regions')
                    .then((response) => {
                        this.regions = response.data;
                    })
            },
            closeModal() {
                this.$emit('close');
            },
            saveForm() {
              axios.post(this.action, this.cityForm)
                  .then((response)=>{
                      this.$notify({
                          title: 'Информация о городе сохранена',
                          type: 'success'
                      });
                      this.closeModal();
                  })
                  .catch((error)=>{
                      this.errors.record(error.response.data.errors);
                  })
            },
        },
        mounted() {
            this.getRegions();
        }
    }
</script>
