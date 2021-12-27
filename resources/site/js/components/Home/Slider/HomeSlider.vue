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
        }
    }
</script>
