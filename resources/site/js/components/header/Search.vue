<template>
    <div class="b-search">
        <input v-model="searchquery"
               v-on:keyup.enter="search"
               v-on:keyup="getSearchData"
               class="b-search__input"
               type="text"
               name="query"
               placeholder="Введите название темы курса или урока">
        <button type="submit" class="b-search__btn" @click.prevent="search">
            <svg class="b-search__icon">
                <use xlink:href="/images/sprite.svg#search"></use>
            </svg>
        </button>
        <div class="search-autocomplete__panel" v-if="themes.length > 0 || courses.length > 0 ">
            <ul class="search-autocomplete__list" v-if="courses.length > 0">
                <li class="search-autocomplete__title">Названия курсов</li>
                <li class="search-autocomplete__item"
                    v-for="course in courses"
                    @click.prevent="autocompleteName(course, 'course')">{{course}}</li>
            </ul>
            <ul class="search-autocomplete__list" v-if="themes.length > 0">
                <li class="search-autocomplete__title">Темы курсов</li>
                <li class="search-autocomplete__item"
                    v-for="theme in themes"
                    @click.prevent="autocompleteName(theme, 'theme')">{{theme}}</li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                searchquery: "",
                themes:[],
                courses:[],
                dataLoaded:false,
            }
        },

        methods: {
            autocompleteName(name, type) {
                this.searchquery = name;
                if(type === 'course') {
                    axios.post('/api/search/autocomplete/course', {title:this.searchquery})
                    .then((response) => {
                        if(response.data) {
                            window.location.href = response.data;
                        }
                    })
                } else {
                    this.search('theme');
                }
            },
            getSearchData() {
                if(this.searchquery.length > 1) {
                    axios.get('/api/search/autocomplete',{params:{search:this.searchquery}})
                        .then((response) =>{
                            this.themes = response.data.themes;
                            this.courses = response.data.courses;
                        })
                } else {
                    this.courses = [];
                    this.themes = [];
                }

            },
            search(type=null) {
                axios.post('/api/search', {search:this.searchquery, type:type})
                .then((response) => {
                    window.location.href=response.data;
                })
            }
        }
    }
</script>
