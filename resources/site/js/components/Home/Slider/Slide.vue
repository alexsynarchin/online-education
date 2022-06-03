<template>
    <div class="home-slider__slide" :class="{
        'home-slider__slide--active':this.index === currentIndex
    }"
    >
        <div class="row">
            <div class="col-md-6">
                <h3 class="home-slider__title">
                    {{slide.title}}
                </h3>
                <p class="home-slider__text">
                    {{slide.text}}
                </p>
                <label class="home-slider__label">
                    Выберите {{slide.label}}:
                </label>
            </div>
        </div>
        <figure class="home-slider__slide-bg">
            <img :src="slide.image">
        </figure>
        <ul class="home-slider-levels">
            <li class="home-slider-levels__item" v-for="(level, index) in slide.levels" @click.prevent="selectlevel(level)">
                <span>
                    {{index + 1}}
                </span>
            </li>
            <li class="home-slider-levels__item" v-if="slide.id === 1" @click.prevent="selectEge">ЕГЭ</li>
        </ul>

    </div>
</template>
<script>
    export default {
        props: {
            slide:{
                type:Object,
                required:true,
            },
            currentIndex: {
                type:Number,
                required: true,
            },
            index: {
                type:Number,
                required: true,
            }
        },
        methods: {
            selectlevel(level) {
                axios.post('/api/slider/filter', {edu_type:this.slide.slug, edu_level: level.id})
                .then((response) => {
                    window.location.href = response.data;
                })
            },
             selectEge() {
                 axios.post('/api/slider/filter', {edu_type:this.slide.slug, ege: true})
                     .then((response) => {
                         window.location.href = response.data;
                     })
             }
        }
    }
</script>
