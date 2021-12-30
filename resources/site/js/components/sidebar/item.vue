<template>
    <section class="filter-sidebar-item" v-if="loaded">
        <h3 class="filter-sidebar-item__title">
            {{title}}
        </h3>
        <div class="b-search">
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
            <li class="filter-sidebar-item-list__item" v-for="(item, index) in itemsPreview">
                <span class="form-checkbox__checkmark"></span> {{item.title}}
            </li>
        </ul>
        <button class="btn filter-sidebar-item__button" @click.prevent="showAll">
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
            edu_type: {
                default:null,
            },
            filterStart: {
                default: null
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
        computed: {
            itemsPreview () {
                return this.items.slice(0, this.items_length);
            }
        },
        methods: {
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
                if(this.edu_type) {
                    url = url + '/' + this.edu_type;
                }
                axios.get(url)
                .then((response)=> {
                    this.items = response.data;
                    this.loaded = true;
                })
            }
        },
        mounted() {
            this.getFilterItems();
        }
    }
</script>
