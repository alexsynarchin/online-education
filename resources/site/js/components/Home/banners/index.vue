<template>
    <section class="mp-banners container">
        <carousel
            :responsive="options"
            :margin="20"
            :loop = "true"
            :stagePadding="60"
            :dots="false"
            :nav="false"
        >
            <template  v-for="(banner, index) in banners">
                <div class="mp-banner-item" v-if="banner.text" @click.prevent="openModal(banner.text)">
                    <img :src="banner.image.link">
                </div>
                <a class="mp-banner-item" style="display: block" target="_blank" :href="banner.link"  v-else>
                    <img :src="banner.image.link">
                </a>
            </template>

            <template  slot="prev">
                <svg viewBox="0 0 14 22" >
                    <use xlink:href="/assets/site/images/sprites.svg#sprite-right-slider-arr"></use>
                </svg></template>
            <template slot="next">
                <svg viewBox="0 0 14 22" >
                    <use xlink:href="/assets/site/images/sprites.svg#sprite-left-slider-arr"></use>
                </svg>
            </template>
        </carousel>
        <el-dialog
            :visible.sync="dialogVisible"
            width="50%"
        >
            <section>
                <div style="word-break: normal;" v-html="currentText">
                </div>
            </section>

        </el-dialog>
    </section>
</template>
<script>
import carousel from '@/site/js/components/carousel/v-owl-carousel.js'
export default {
        components: { carousel },
        props: {
            banners: {
                type:Array,
            }
        },
        methods: {
            openModal(text) {
                this.dialogVisible = true;
                this.currentText = text;
            }
        },
        data() {
            return {
                dialogVisible:false,
                currentText: "",
                options: {
                    0:{
                        items:1,
                    },
                    600:{
                        items: 3,
                    },
                    1024: {
                        items: 4,
                    }
                }
            }
        },
    }
</script>
