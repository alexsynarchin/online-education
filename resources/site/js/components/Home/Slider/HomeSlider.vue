<template>
    <section class="home-slider">
        <transition-group name="fade" tag="div" class="home-slider__content container">
            <slide
                v-for="(slide, index) in slides"
                :slide="slide"
                :index="index"
                :currentIndex="currentIndex"
                :key="slide.id"
            ></slide>
        </transition-group>
        <div class="home-slider-nav__wrap">
            <div class="container">
                <ul class="home-slider-nav">
                    <li class="home-slider-nav__item" v-for="(nav, index) in slides"
                        @click.prevent="selectNav(index)"
                        :class="{
                        'home-slider-nav__item--active': index === currentIndex
                    }">
                        <span>{{nav.title}}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="home-slider-step-nav__wrap">
            <div class="container">
                <div class="home-slider-step-nav">
                <span class="home-slider-step-nav__prev" @click.prevent="prev">
                    <svg viewBox="0 0 14 22">
                        <use xlink:href="/assets/site/images/sprites.svg#sprite-right-slider-arr"></use>
                    </svg>
                </span>
                    <span class="home-slider-step-nav__next" @click.prevent="next">
                    <svg viewBox="0 0 14 22">
                        <use xlink:href="/assets/site/images/sprites.svg#sprite-left-slider-arr"></use>
                    </svg>
                </span>
                </div>
            </div>
        </div>

    </section>
</template>
<script>
    import Slide from "./Slide";
    export default {
        components: {
            Slide,
        },
        props:['slides'],
        data() {
            return {
                currentIndex: 0
            }
        },
        methods: {
            selectNav(index) {
                this.currentIndex = index;
            },
            next: function() {
                if(this.currentIndex < this.slides.length - 1 ) {
                    this.currentIndex += 1;
                }

            },
            prev: function() {
                if(this.currentIndex > 0) {
                    this.currentIndex -= 1;
                }

            }
        }
    }
</script>
