<template>
    <section class="filter-sidebar">
        <sidebar-item
            v-if="selected.edu_type === 1 && loaded"
            :title="'Подготовка к Егэ'"
            :placeholder="'Поиск по предметам'"
            :type="'yege'"
            :show-search="false"
            :filter-start="selected.yege"
            @select-item="selectItem"
            :selected = this.selected
        ></sidebar-item>
        <sidebar-item
            v-if="(selected.edu_type === 2 || selected.edu_type === 3 || selected.edu_type === 4) && loaded"
            :title="selected.edu_type === 4 ? 'Программы':'Специальность'"
            :placeholder="'Поиск по ' + (selected.edu_type === 4?'программам':'специальностям')"
            :type="'specialty'"
            :show-search="true"
            :filter-start="selected.specialties"
            :direction="selected.direction"
            @select-item="selectItem"
            :edu_type="filterStart.edu_type"
            :selected = this.selected
        ></sidebar-item>
        <sidebar-item
            v-if="loaded && selected.edu_type !== 4"
            :title="'Предмет'"
            :placeholder="'Поиск по предметам'"
            :type="'subject'"
            :filter-start="selected.subjects"
            @select-item="selectItem"
            :show-search="ShowSearch"
            :selected = this.selected
        ></sidebar-item>
        <sidebar-item
            v-if="loaded"
            :title="level_title"
            :show-search="false"
            :placeholder="'Поиск по ' + level_title + 'ам'"
            :type="'edu_level'"
            :filter-start="selected.levels"
            @select-item="selectItem"
            :edu_type="filterStart.edu_type"
            :selected = this.selected
        ></sidebar-item>
        <sidebar-item
            v-if="loaded"
            title="Тема"
            :show-search="true"
            :placeholder="'Поиск по темам'"
            :type="'theme'"
            :filter-start="selected.themes"
            @select-item="selectItem"
            :subject="selected.subjects"
            :selected = this.selected
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
                default:{yege:[], levels:[], subjects:[], direction:null, specialties:[], edu_type:null, themes:[], sort:{value:'', direction:''}},
            }
        },
        data() {
            return {
            selected: {},
            level_title:"",
            loaded:false,
            }
        },
        computed: {
            ShowSearch:function () {
                let result = true;
                if(this.selected.edu_type === 1) {
                    result = false;
                }
                return result;
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
                if(data.type ==='specialty') {
                    let index = this.selected.specialties.findIndex(x => x == data.id);
                    if( index != -1) {
                        this.selected.specialties.splice(index, 1);
                    } else {
                        this.selected.specialties.push(data.id);
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
            },
            sortCourses(data) {
                this.selected.sort = {
                    value: '',
                    direction: ''
                }
                this.selected.sort.value = data.value;
                this.selected.sort.direction = data.direction;
                console.log(this.selected.sort)
                axios.post('/api/catalog/filter', this.selected)
                    .then((response) => {
                        EventBus.$emit('get-filtered-courses', response.data)
                    })
            },
        },
        mounted() {
            this.selected = this.filterStart;
            this.loaded = true;
            if(this.selected.edu_type === 1) {
                this.level_title = 'Класс';
            } else if (this.selected.edu_type === 4){
                this.level_title = 'Возраст';
            } else {
                this.level_title = 'Курс';
            }
            axios.post('/api/catalog/filter', this.selected)
                .then((response) => {
                    EventBus.$emit('get-filtered-courses', response.data)
                })
        },
        created() {
            EventBus.$on('sort-courses', this.sortCourses)

        }
    }
</script>
