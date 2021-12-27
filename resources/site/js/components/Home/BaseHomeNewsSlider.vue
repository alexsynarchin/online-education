<template>
    <section class="b-index-news">
        <div class="container">
            <div class="row">
                <div class="col">
                    <swiper class="b-news-slider" :options="swiperOption">
                        <swiper-slide v-for="(slideNewsItem, index) in slidesNews" :key="index">
                            <a class="news-slide news-slide--hover" :href="slideNewsItem.link">
                                <div class="news-slide__img" :style="{ backgroundImage: 'url(' + slideNewsItem.src + ')' }"></div>
                                <div class="news-slide__des">
                                    <h2 class="news-slide__des_title">{{ slideNewsItem.title }}</h2>
                                    <p class="news-slide__des_text">
                                        {{ slideNewsItem.description }}
                                    </p>
                                </div>
                            </a>
                        </swiper-slide>
                        <div class="swiper-button-prev news-btn-nav news-btn-nav--prev" slot="button-prev">
                            <svg class="news-btn-nav__icon">
                                <use xlink:href="../../../assets/image/sprite.svg#arrow-left"></use>
                            </svg>
                        </div>
                        <div class="swiper-button-next news-btn-nav news-btn-nav--next" slot="button-next">
                            <svg class="news-btn-nav__icon">
                                <use xlink:href="../../../assets/image/sprite.svg#arrow-right"></use>
                            </svg>
                        </div>
                    </swiper>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

import 'swiper/dist/css/swiper.css'

import { swiper, swiperSlide } from 'vue-awesome-swiper'

export default {
    components: {
        swiper,
        swiperSlide
    },
    data () {
        return {
            swiperOption: {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                breakpoints: {
                480: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                780: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                984: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
            },
            slidesNews: [
                {
                    link: '#',
                    src: require('../../../assets/image/novost_1.jpg'),
                    title: 'Новый учебный год!',
                    description: 'Как и все хорошее, каникулы имеют свойство заканчиваться. И, несмотря на то что многие ребята с нетерпением ждут новой встречи со своими'
                },
                {
                    link: '#',
                    src: require('../../../assets/image/novost_2.jpg'),
                    title: 'Статья №1',
                    description: 'Как и все хорошее, каникулы имеют свойство заканчиваться. И, несмотря на то что многие ребята с нетерпением ждут новой встречи со своими'
                },
                {
                    link: '#',
                    src: require('../../../assets/image/novost_3.jpg'),
                    title: 'Новость года!',
                    description: 'Как и все хорошее, каникулы имеют свойство заканчиваться. И, несмотря на то что многие ребята с нетерпением ждут новой встречи со своими'
                },
                {
                    link: '#',
                    src: require('../../../assets/image/novost_4.jpg'),
                    title: 'Новый учебный год!',
                    description: 'Как и все хорошее, каникулы имеют свойство заканчиваться. И, несмотря на то что многие ребята с нетерпением ждут новой встречи со своими'
                }
            ]
        }
    }
}
</script>

<style lang="stylus" scoped>

@import '../../../assets/style/_mixins'


.b-index-news
    size 100%
    padding-bottom 90px

.b-news-slider
    width 100%
    height 450px

.news-slide
    width 100%
    display flex
    flex-direction column
    justify-content space-between
    border-radius 20px
    overflow hidden
    box-shadow -2px 5px 10px -6px rgba(0,0,0,0.3)
    text-decoration none

.news-slide--hover
    transition box-shadow .25s ease
    &:hover
        box-shadow -2px 5px 5px -6px rgba(0,0,0,0.3)

.news-slide__img
    size 100% 170px
    background-size cover

.news-slide__des
    size 100% 50%
    padding 20px 10px
    
.news-slide__des_title
    font-family "RobotoRegular"
    font-size rem(16px)
    font-weight 200
    color #000
    text-decoration none

.news-slide__des_text
    font-family "RobotoRegular"
    font-size rem(14px)
    font-weight 200
    color #000
    text-decoration none

.news-btn-nav
    top auto
    bottom 10px
    size 52px
    display flex
    justify-content center
    align-items center
    border-radius 50%
    background #FFFFFF
    box-shadow -2px 5px 8px -6px rgba(0,0,0,0.3)

.news-btn-nav--next
    left 80px
    

.news-btn-nav__icon
    size 12px

</style>

