<template>
    <section class="course-lessons">
        <div class="row align-items-center">
            <div class="col-md-9">
                <h3 class="course-item__title">Уроки курса</h3>
            </div>
            <div class="col-md-3">
                <a class="button button--w-100" :href="'/profile/courses/'+ course_slug + '/lesson-create'">
                    Создать урок
                </a>
            </div>
        </div>
        <ul class="nav b-tab">
            <li class="nav-item b-tab__title" v-for="(tab, index) in tabs">
                <a href=""  class="nav-link b-tab__link" :class="{'active': tab.type === active_tab}" @click.prevent="selectTab(tab.type)">
                    {{tab.title}}
                </a>
            </li>
        </ul>
    </section>
</template>
<script>
    export default {
        props: {
          course_slug: {
              type:String,
              required:true
          },
            course_lessons:{
              type:Array,
                required:true,
            }
        },
        data() {
            return {
                active_tab:'active',
                lessons: [],
                tabs:[
                    {
                        type:'active',
                        title: "Активные"
                    },
                    {
                        type:'moderate',
                        title: "На модерации"
                    },
                    {
                        type:'draft',
                        title: "Черновики"
                    },
                    {
                        type:'cancel',
                        title: "Отклоненные"
                    },
                ],
            }
        },
         methods: {
            selectTab(type) {
                this.active_tab = type;
            },
         },
    }
</script>
