<template>
    <section class="course-list">
        <div class="col-md-12">
            <el-row type="flex" class="mb-3">
                <el-col :span="24">
                    <el-select v-model="status" filterable placeholder="Статус"  @change="Filter()">
                        <el-option
                            v-for="item in status_list"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"

                        >
                        </el-option>
                    </el-select>
                    <el-select v-model="subject" filterable placeholder="Предмет"  @change="Filter()">
                        <el-option
                            v-for="item in subjects"
                            :key="item.id"
                            :label="item.title"
                            :value="item.id"

                        >
                        </el-option>
                    </el-select>
                    <el-select v-model="edu_type" filterable placeholder="Тип образования"  @change="Filter()">
                        <el-option
                            v-for="item in edu_types"
                            :key="item.id"
                            :label="item.title"
                            :value="item.id"

                        >
                        </el-option>
                    </el-select>
                    <el-select v-model="author" filterable placeholder="Автор"  @change="Filter()">
                        <el-option
                            v-for="item in authors"
                            :key="item.id"
                            :label="item.surname + ' ' + item.name"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                    <el-button type="primary" @click.preven="resetFilter">Сбросить фильтры</el-button>
                </el-col>
            </el-row>
            <el-row type="flex" class="mb-3">
                <el-col :span="8">
                    <el-input
                        v-model="filters[0].value"
                        size="large"
                        width="100%"
                        placeholder="Поиск: Название курса"/>
                </el-col>
            </el-row>
            <data-tables :data="courses"  :filters="filters">
                <el-table-column
                    type="index"
                >
                </el-table-column>
                <el-table-column
                    label="Название курса"
                    sortable
                >
                    <template slot-scope="scope">
                        <div style="word-break: normal">
                            {{scope.row.title}}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Автор"

                    sortable
                >
                    <template slot-scope="scope">
                        <span >{{ scope.row.author.name}} <br> {{scope.row.author.surname}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Предмет"
                    prop="subject.title"
                    sortable
                >
                </el-table-column>
                <el-table-column
                    label="Тип образования"
                    sortable
                >
                    <template slot-scope="scope">
                        <div style="word-break: normal">
                            {{scope.row.edu_type.title}}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Уроки на модерации"
                >
                    <template v-slot="scope" >
                        <div style="text-align: center; color: red" v-if="scope.row.lessons_count > 0">
                            +{{scope.row.lessons_count}}
                        </div>
                        <div style="text-align: center" v-else>
                            {{scope.row.lessons_count}}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="status"
                    label="Статус"


                >
                    <template slot-scope="scope" >
                        <el-tag
                            :type="statusColor(scope.row.status)"
                            disable-transitions>{{statusText(scope.row.status)}}</el-tag>

                    </template>
                </el-table-column>

                <el-table-column
                    label="Действия"
                >

                    <template slot-scope="scope">
                        <el-button
                            size="mini"
                            type="primary"
                            @click="handleEdit(scope.$index, scope.row)">Просмотр</el-button>

                    </template>
                </el-table-column>
            </data-tables>

        </div>
    </section>
</template>
<script>
export default {
    methods:{
        handleEdit(index, row){
            let url = '/admin/courses/' + row.id;
            window.location = url;
        },
        statusText(status){
            switch(status) {
                case 0:
                    return 'Черновик';
                    break;
                case 1:
                    return 'Модерация';
                    break;
                case 2:
                    return 'Опубликован';
                    break;
                case 3:
                    return 'Отклонен';
                    break;
                default:
                    return  'info'
            }
        },
        statusColor(status){
            switch(status) {
                case 0:
                    return 'info';
                    break;
                case 1:
                    return 'warning';
                    break;
                case 2:
                    return 'success';
                    break;
                case 3:
                    return 'danger';
                    break;
                default:
                    return  'info'
            }
        },
        resetFilter(){
            this.status = null;
            this.subject = null;
            this.edu_type = null;
            this.author = null;
            this.getCourses();
        },
        Filter(){
            this.getCourses();
        },
        getCategoryTypes(type) {
            axios.get('/api/admin/category-types/' + type)
                .then((response) => {
                    if(type === 'edu_type') {
                        this.edu_types = response.data;
                    }
                    if(type === 'subject') {
                        this.subjects = response.data;
                    }
                })
        },
        getCourses(){
            axios.get('/api/admin/courses',  {
                params: {
                    status: this.status,
                    subject:this.subject,
                    edu_type:this.edu_type,
                    author:this.author
                }
            })
                .then((response)=>{
                    this.courses = response.data;

                })
                .catch((error)=>{
                    console.log(error)
                })
        }
    },
    data(){
        return{
            subjects: [],
            edu_types:[],
            authors:[],
            courses:[],
            filters: [
                {
                    prop: 'title',
                    value: ""
                }
            ],
            status:1,
            subject:null,
            edu_type:null,
            author:null,
            status_list:[
                {
                    value:1,
                    label:"Модерация"
                },
                {
                    value:2,
                    label:"Опубликован"
                },
                {
                    value:3,
                    label:"Отклонен"
                },
            ]
        }
    },
    mounted() {
        this.getCourses();
        this.getCategoryTypes('edu_type');
        this.getCategoryTypes('subject');
    }
}
</script>
