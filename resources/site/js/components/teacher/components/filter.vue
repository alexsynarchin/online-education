<template>
    <section class="search-teachers-filter">
        <div class="search-teachers-filter__item" v-for="(item, index) in filters">
            <label class="search-teachers-filter__label">
                {{item.label}}
            </label>
            <el-select class="search-teachers-filter__select"  v-model="item.value" multiple :placeholder="item.label">
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
                        options: [],
                        value:null,
                    },
                    {
                        type:'city',
                        label:'Выберите ваш город:',
                        options: [],
                        value:null,
                    },
                    {
                        type:'edu_type',
                        label:'Выберите учебное заведение:',
                        options: [],
                        value:null,
                    },
                ],
                cities: [],
                city:null,
            }
        }
    }
</script>
