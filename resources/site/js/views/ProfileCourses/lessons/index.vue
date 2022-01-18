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
        <ul class="nav b-tab mb-3">
            <li class="nav-item b-tab__title" v-for="(tab, index) in tabs">
                <a href=""  class="nav-link b-tab__link" :class="{'active': tab.type === active_tab}" @click.prevent="selectTab(tab.type, tab.value)">
                    {{tab.title}} ({{tab.count}})
                </a>
            </li>
        </ul>
        <lesson-item :lesson="lesson"
                     v-for="(lesson, index) in filteredLessons"
                     :key="lesson.id"
                     @handle-edit="handleEdit"
                    @handle-remove="handleRemove"
        ></lesson-item>
    </section>
</template>
<script>
    import LessonItem from './item'
    export default {
        components:{
            LessonItem,
        },
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
        computed: {
            filteredLessons: function() {
                return this.lessons.filter(lesson => {
                        return lesson.status == this.active_status;
                    })
            }
        },
        data() {
            return {
                active_tab:'active',
                active_status:2,
                lessons: [],
                tabs:[
                    {
                        type:'active',
                        value:2,
                        title: "Активные",
                        count: this.course_lessons.filter(lesson =>  lesson.status == 2).length
                    },
                    {
                        type:'moderate',
                        value:1,
                        title: "На модерации",
                        count: this.course_lessons.filter(lesson => lesson.status == 1).length
                    },
                    {
                        type:'draft',
                        value:0,
                        title: "Черновики",
                        count: this.course_lessons.filter(lesson => lesson.status == 0).length
                    },
                    {
                        type:'cancel',
                        value:3,
                        title: "Отклоненные",
                        count: this.course_lessons.filter(lesson => lesson.status == 3).length
                    },
                ],
            }
        },
         methods: {
            handleRemove(id) {
                let index = this.lessons.findIndex(x => x.id === id);
                this.lessons.splice(index, 1);
            },
            handleEdit(lesson_slug) {
                window.location.href = '/profile/courses/' + this.course_slug + '/lesson/' + lesson_slug + '/edit';
            },
            selectTab(type, value) {
                this.active_tab = type;
                this.active_status = value;
            },
         },
       async mounted() {
           this.lessons = this.course_lessons;
        }
    }
</script>
