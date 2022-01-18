<template>
    <section class="filter-sidebar">
        <sidebar-item
        :title="'Предмет'"
        :placeholder="'Поиск по предметам'"
        :type="'subject'"
        :filter-start="selected.subject"
        @select-item="selectItem"
        ></sidebar-item>
        <sidebar-item
            :title="level_title"
            :placeholder="'Поиск по ' + level_title + 'ам'"
            :type="'edu_level'"
            :filter-start="selected.level"
            @select-item="selectItem"
            :edu_type="filterStart.edu_type"
        ></sidebar-item>
        <sidebar-item
            title="Тема курса"
            :placeholder="'Поиск по темам'"
            :type="'theme'"
            :filter-start="selected.theme"
            @select-item="selectItem"
            :subject="filterStart.subject"
        ></sidebar-item>
    </section>
</template>
<script>
    import SidebarItem from './item';
    export default {
        components: {
            SidebarItem,
        },
        props:{
            filterStart:{
                type:Object,
                default:{level:null, subject:null, edu_type:null},
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
                    this.selected.subject = data.id;
                }
                if(data.type === 'edu_level') {
                    this.selected.level = data.id;
                }
                if(data.type ==='theme') {
                    this.selected.theme = data.id;
                }
                axios.post('/api/catalog/filter', this.selected)
                .then((response) => {
                    console.log(response.data);
                    //window.location.href = response.data;
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
