<template>
    <section class="filter-sidebar-item">
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
                type:String,
            },
        },
        data() {
            return {
                search: "",
            }
        },
        methods: {
            getFilterItems() {

            }
        },
        mounted() {
            this.getFilterItems();
        }
    }
</script>
