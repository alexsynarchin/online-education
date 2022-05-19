<template>
    <section class="search-teachers-filter">
        <div class="search-teachers-filter__item" v-for="(item, index) in filters">
            <label class="search-teachers-filter__label"
            :class="{
                'search-teachers-filter__label--selected':item.value,
            }">
                {{item.label}}
            </label>
            <el-select class="search-teachers-filter__select"
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
        </div>

    </section>
</template>
<script>
    export default {
        data() {
            return {
                filters: [
                    {
                        type:'edu_type',
                        label:'Выберите тип учебного заведения:',
                        options: [
                            {
                                id:'preschool',
                                slug:  "preschool",
                                title: "Дошкольное",
                            },
                            {
                                id:'school',
                                slug:'school',
                                title:'Школа'
                            },
                            {
                                id:'secondary_special',
                                slug:"secondary_special",
                                title: "Средне-специальное",
                            },
                            {
                                id:'university',
                                slug:'university',
                                title:'ВУЗ'
                            },


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
            }
        },
        methods: {
            selectFilter(type, value) {
                if(type != 'edu_institution' && this.filters[0].value && this.filters[1].value) {
                    this.filters[2].value = null;
                    this.filters[2].options = [];
                    this.getFilterData('edu_institution');
                } else if(type === 'edu_institution') {
                    let filter = {
                        type:this.filters[0].value,
                        city:this.filters[1].value,
                        edu_institution:this.filters[2].value
                    };
                    this.searchTeacher(filter);
                }
            },
            searchTeacher(filter){
                this.$emit('search-teacher', filter)
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
            }
        },
        mounted() {
            this.getFilterData('city');
        }
    }
</script>
