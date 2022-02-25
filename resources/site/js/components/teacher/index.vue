<template>
    <section class="search-teachers mb-4">
        <search-filter @search-teacher="searchTeacher"></search-filter>
        <div class="row" v-if="teachers.length > 0">
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3" v-for="(teacher, index) in teachers" >
               <a  :href="'/search-teachers/' + teacher.id" class="teacher-item">
                   <figure class="teacher-item__avatar">
                       <img :src="teacher.avatar">
                   </figure>
                   <h4 class="teacher-item__title">
                       {{teacher.name}} {{teacher.surname}}
                   </h4>

                   <ul class="teacher-item__list">
                       <li class="teacher-item__list-item">
                           Образование:
                           <span v-for="(item, index) in teacher.edu_institutions">
                           {{item.title}}<template v-if="(teacher.edu_institutions.length - 1) != index">,</template>
                           </span>
                       </li>
                   </ul>
               </a>
            </div>

        </div>
        <el-alert
            v-else
            :closable="false"
            title="По данному запросу преподаватели не найдены"
            type="info">
        </el-alert>
    </section>
</template>
<script>
import SearchFilter from "./components/filter";
    export default {
        components: {
            SearchFilter,
        },
        data() {
            return {
                teachers:[],
            }
        },
        methods: {
            searchTeacher(filter) {
                console.log(filter);
                axios.post('/api/search-teacher', filter)
                .then((response) => {
                    this.teachers = response.data;
                })
            }
        }

    }
</script>
