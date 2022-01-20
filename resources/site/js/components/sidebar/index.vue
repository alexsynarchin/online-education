<template>
    <section class="filter-sidebar">
        <sidebar-item
            v-if="selected.edu_type === 1"
            :title="'Подготовка к Егэ'"
            :placeholder="'Поиск по предметам'"
            :type="'yege'"
            :filter-start="selected.yege"
            @select-item="selectItem"
        ></sidebar-item>
        <sidebar-item
        :title="'Предмет'"
        :placeholder="'Поиск по предметам'"
        :type="'subject'"
        :filter-start="selected.subjects"
        @select-item="selectItem"
        ></sidebar-item>
        <sidebar-item
            :title="level_title"
            :placeholder="'Поиск по ' + level_title + 'ам'"
            :type="'edu_level'"
            :filter-start="selected.levels"
            @select-item="selectItem"
            :edu_type="filterStart.edu_type"
        ></sidebar-item>
        <sidebar-item
            title="Тема курса"
            :placeholder="'Поиск по темам'"
            :type="'theme'"
            :filter-start="selected.themes"
            @select-item="selectItem"
            :subject="selected.subjects"
        ></sidebar-item>
    </section>
</template>
<script>
    import SidebarItem from './item';
    import EventBus from "../../EventBus";
    export default {
        components: {
            SidebarItem,
        },
        props:{
            filterStart:{
                type:Object,
                default:{levels:[], subjects:[], edu_type:null, themes:[]},
            }
        },
        data() {
            return {
            selected: {},
            level_title:"",
            }
        },
        methods: {
            selectItem(data) {
                this.$root.filtered = true;
                if(data.type === 'subject') {
                    let index = this.selected.subjects.findIndex(x => x == data.id);
                    if( index != -1) {
                        this.selected.subjects.splice(index, 1);
                    } else {
                        this.selected.subjects.push(data.id);
                    }

                }
                if(data.type === 'edu_level') {
                    let index = this.selected.levels.findIndex(x => x == data.id);
                    if( index != -1) {
                        this.selected.levels.splice(index, 1);
                    } else {
                        this.selected.levels.push(data.id);
                    }

                }
                if(data.type ==='theme') {
                    let index = this.selected.themes.findIndex(x => x == data.id);
                    if( index != -1) {
                        this.selected.themes.splice(index, 1);
                    } else {
                        this.selected.themes.push(data.id);
                    }

                }
                if(data.type ==='yege') {
                    let index = this.selected.yege.findIndex(x => x == data.id);
                    if( index != -1) {
                        this.selected.yege.splice(index, 1);
                    } else {
                        this.selected.yege.push(data.id);
                    }

                }
                axios.post('/api/catalog/filter', this.selected)
                .then((response) => {
                    if(this.selected.redirect) {
                        window.location.href = response.data;
                    } else {
                        EventBus.$emit('get-filtered-courses', response.data)
                    }
                })
            }
        },
        mounted() {
            this.selected = this.filterStart;
            if(this.selected.edu_type == 1) {
                this.level_title = 'Класс';
            } else {
                this.level_title = 'Курс';
            }
        }
    }
</script>
