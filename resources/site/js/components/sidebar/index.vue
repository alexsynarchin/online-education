<template>
    <section class="filter-sidebar">
        <sidebar-item
        :title="'Предмет'"
        :placeholder="'Поиск по предметам'"
        :type="'subject'"
        :filter-start="filterStart.subject"
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
        methods: {

        }
    }
</script>
