<template>
    <section>
        <ul class="breadcrumb">
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/">Главная</a>
            </li>
            <li class="breadcrumb__item">
                <a class="breadcrumb__link" href="/profile">Профиль</a>
            </li>
            <li class="breadcrumb__item">
                Мои студенты
            </li>
        </ul>
        <h1 class="b-profile-user__title">Мои Студенты</h1>
        <div class="row" v-if="students.length > 0">
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3" v-for="(student, index) in students" >
                <div  class="teacher-item">
                    <figure class="teacher-item__avatar">
                        <img :src="student.user.avatar">
                    </figure>
                    <h4 class="teacher-item__title">
                        {{student.user.name}} {{student.user.surname}}
                    </h4>
                </div>
            </div>

        </div>
        <el-alert
            v-else
            :closable="false"
            title="У вас нет студентов"
            type="info">
        </el-alert>
    </section>
</template>
<script>
    export default {
        data() {
            return {
                students: [],
            }
        },
        methods: {
            getStudents() {
                axios.get('/api/profile/my-students')
                    .then((response) => {
                        this.students = response.data;
                    })
            },
        },
        mounted() {
            this.getStudents();
        }
    }
</script>
