<template>
    <section v-if="loaded">
        <h3 class="block-title">
            Настройки главной страницы
        </h3>
        <el-form :model="form" label-position="top">
            <slider :delete_img="form.delete_img" :list="form.slider" @sort="sort"></slider>
            <banners :list="form.banners" :delete_img="form.delete_img" @sort="sort"></banners>
            <for-whom :list="form.for_whom" :delete_img="form.delete_img" @sort="sort"></for-whom>
            <h4>Ценовая политика</h4>
            <el-form-item label="Текст">
                <el-input type="textarea" v-model="form.price.text"></el-input>
            </el-form-item>
            <price :list="form.price_list"></price>
            <you-get :list="form.you_get" :delete_img="form.delete_img"></you-get>
            <h4>YouTube Видео</h4>
            <el-form-item prop="youtube_link" label="Ссылка на youtube">
                <el-input v-model="form.youtube_link"></el-input>
            </el-form-item>
            <el-button type="success" @click.prevent="store">Сохранить</el-button>
        </el-form>

    </section>
</template>
<script>
import Slider from './main-page/slider/index';
import Banners from "./main-page/banners/index";
import ForWhom from './main-page/for-whom/index';
import Price from './main-page/price/index'
import YouGet from "./main-page/you-get";
    export default {
    components: {
        Slider, Banners, ForWhom, Price, YouGet,
    },
        data() {
         return {
             loaded:false,
             blocks:[],
             form: {
                 slider:[],
                 delete_img:[],
                 banners:[],
                 for_whom:[],
                 price: {
                     text:"",
                 },
                 price_list:[],
                 you_get:[],
                 youtube_link:'',
             },

         }
        },
        methods: {
            sort(data){
                this.form[data.list_name] = data.list;
                console.log(this.form[data.list_name]);
            },
            prepareForm() {
                if(this.blocks.youtube_link) {
                    this.form.youtube_link = this.blocks.youtube_link;
                }
                if(this.blocks.youtube_link) {
                    this.form.youtube_link = this.blocks.youtube_link;
                }
                if(this.blocks.slider) {
                    this.form.slider = this.blocks.slider;
                }
                if(this.blocks.banners) {
                    this.form.banners = this.blocks.banners;
                }
                if(this.blocks.for_whom) {
                    this.form.for_whom = this.blocks.for_whom;
                }
                if(this.blocks.price) {
                    this.form.price = this.blocks.price;
                }
                if(this.blocks.price_list) {
                    this.form.price_list = this.blocks.price_list;
                }
                if(this.blocks.you_get) {
                    this.form.you_get = this.blocks.you_get;
                }
                this.loaded = true;
            },
            store() {
                this.$root.isLoading = true;
                axios.post('/api/admin/main-page/store', this.form)
                .then((response) => {
                    this.getData();
                    this.$root.isLoading = false;
                    console.log(response.data);
                    this.$notify({
                        title: 'Страница сохранена',
                        type: 'success'
                    });
                })

            },
        getData() {
            axios.get('/api/admin/main-page/data')
            .then((response) => {
                this.blocks = response.data;
                console.log(this.blocks);
                this.prepareForm();
            })
        },
        },
        async mounted() {
            await this.getData();
        }
    }
</script>
