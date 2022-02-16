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
            <a style="display: block" :href="banner.link"  v-for="(banner, index) in banners">
                <img :src="banner.image.link">
            </a>
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
        data() {
            return {
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
