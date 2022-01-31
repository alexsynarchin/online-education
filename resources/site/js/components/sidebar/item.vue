<template>
    <section class="filter-sidebar-item" v-if="loaded">
        <h3 class="filter-sidebar-item__title" v-if="type != 'yege'">
            {{title}}
        </h3>
        <div class="b-search" v-if="type != 'yege'">
            <input class="b-search__input" type="text" v-model="search" name="query" :placeholder="placeholder">
            <button type="submit" class="b-search__btn"  @click.prevent="">
                <svg class="b-search__icon">
                    <use xlink:href="/images/sprite.svg#search"></use>
                </svg>
            </button>
        </div>
        <ul class="filter-sidebar-item-list"
            :class="{
            'filter-sidebar-item-list--scroll': !preview_mode
            }"
        >
            <li class="filter-sidebar-item-list__item" v-for="(item, index) in itemsPreview"
                @click.prevent = "selectItem(item)"
            >
                <span class="form-checkbox__checkmark"
                      :class="{
                          'form-checkbox__checkmark--selected': filterStart.findIndex(x => x == item.id) != -1
                }"
                ></span> {{item.title}} <span v-if="type != 'yege'" style="margin-left: 5px"> ({{item[countName]}})</span>
            </li>
        </ul>
        <button class="btn filter-sidebar-item__button" @click.prevent="showAll" v-if="type != 'yege'">
            <svg viewBox="0 0 14 9" class="filter-sidebar-item__icon"
                 :class="{
                'filter-sidebar-item__icon--top': !preview_mode
                 }"
            >
                <use xlink:href="/assets/site/images/sprites.svg?ver=11#sprite-arr-bottom"></use>
            </svg>
            <span v-if="preview_mode">
                Показать все
            </span>
            <span v-else>
                Свернуть
            </span>
        </button>

    </section>
</template>
<script>
    export default {
        props: {
            title: {
                type:String,
            },
            placeholder: {
                type:String,
            },
            direction: {
                default:null,
            },
            edu_type: {
                default:null,
            },
            subject: {
                default:null,
            },
            filterStart: {
                default: null
            },
            selected:{
                required: true
            },
            type: {
              type:String,
              required:true,
            },
        },
        data() {
            return {
                preview_mode:true,
                loaded:false,
                search: "",
                items: [],
                items_length: 6,
            }
        },
        watch: {
            search(){
                console.log(this.search)
            }
        },
        computed: {
            countName() {
                let name = '';
                if(this.type ==='specialty') {
                    name = 'courses_specialty_count';
                }
                if(this.type ==='subject') {
                    name = 'courses_subject_count';
                }
                if(this.type ==='edu_level') {
                    name = 'courses_level_count';
                }
                if(this.type ==='theme') {
                    name = 'courses_theme_count';
                }
                return name;
            },
            itemsPreview () {
                return this.filteredItems.slice(0, this.items_length)
            },
            filteredItems() {
            return this.items.filter(item => {
                    return item.title.toLowerCase().includes(this.search.toLowerCase())
                });

            }
        },
        methods: {
            selectItem(item) {
                this.$emit('select-item', {id: item.id, type:this.type})
                this.getFilterItems();
            },
            showAll() {
                this.preview_mode = !this.preview_mode;
                if(this.preview_mode) {
                    this.items_length = 6;
                } else {
                    this.items_length= this.items.length;
                }
            },
            getFilterItems() {
                let url = '/api/category-' + this.type;
                let request = {
                    selected:this.selected
                };
                if(this.edu_type && !this.direction) {
                    url = url + '/' + this.edu_type;
                }
                if(this.subject) {
                    url = url + '/' + this.subject;
                }
                if(this.direction && this.edu_type) {
                    url = url + '/' + this.direction;
                    request.edu_type_id = this.edu_type
                }
                axios.get(url, {params: request})
                .then((response)=> {
                    this.items = response.data;
                    this.loaded = true;
                })
            }
        },
        mounted() {
            if(this.type ==='yege') {
             this.items.push({
                 id:1,
                 title:'Подготовка к ЕГЭ',
             })
                this.loaded = true;
            } else {
                this.getFilterItems();
            }
        }
    }
</script>
