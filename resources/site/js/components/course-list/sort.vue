<template>
    <section class="course-list-sort">
        <label class="course-list-sort__label">
            Сортировать по:
        </label>
        <span class="course-list-sort__item"
              v-for="(item, index) in SortList" @click="sortCourses(item, index)"
              :class="{'course-list-sort__item--active': index === selectedIndex}"
        >
                {{item.title}}
            </span>
    </section>
</template>
<script>
import EventBus from "../../EventBus";
    export default {
        data() {
            return {
                selectedIndex:'',
                direction: 'ASC',
                SortList: [
                    {
                        title:'Рейтингу',
                        value:'rating',
                        direction:'asc',
                    },
                    {
                        title:'Новизне',
                        value:'created_at',
                        direction:'asc',
                    },
                    {
                        title:'Цене',
                        value:'price',
                        direction:'asc',
                    },

                ],
            }
        },
        methods: {
            sortCourses(data, index) {
                if(this.selectedIndex === index) {
                    if(this.direction === 'desc') {
                        this.direction= 'asc';
                    } else {
                        this.direction = 'desc';
                    }
                } else {
                    this.direction= 'desc'
                }
                this.selectedIndex = index;
                let sortItem = data;
                sortItem.direction = this.direction;
                EventBus.$emit('sort-courses', data)
            }
        }
    }
</script>
