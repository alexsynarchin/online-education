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
            :parent_id="selected.edu_type"
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
                if(data.type === 'subject') {
                    this.selected.subject = data.id;
                }
                if(data.type === 'edu_level') {
                    this.selected.level = data.id;
                }
                axios.post('/api/catalog/filter', this.selected)
                .then((response) => {
                    window.location.href = response.data;
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
