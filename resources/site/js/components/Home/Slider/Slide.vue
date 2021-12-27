<template>
    <div class="home-slider__slide" :class="{
        'home-slider__slide--active':this.index === currentIndex
    }"
    style="background-image: url('/assets/site/images/home-slider.png')"
    >
        <div class="row">
            <div class="col-md-8">
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
        }
    }
</script>
