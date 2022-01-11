<template>
    <div class="star-rating">

        <h5 v-if="showTitle" class="star-rating__title">Оценка курса:</h5>
        <ul class="star-rating__list">
            <li :key="star" class="star-rating__item" v-for="star in maxStars" :class="{'star-rating__item--active': star <=  stars}" @click="rate(star)">
              <svg viewBox="0 0 36 36">
                <use xlink:href="/assets/site/images/sprites.svg?ver=35#sprite-star"></use>
              </svg>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: {
            maxStars: {
                type:Number,
                default:5,
            },
            fontSize: {
                type:Number,
                default:1,
            },
            showTitle: {
                type:Boolean,
                default:false,
            },
            value: {
                type:Number,
                default:0,
            },
        },
        data() {
            return {
                stars: this.value,
            }
        },
        methods:{
            rate(star) {

                if (
                    typeof star === 'number' &&
                    star <= this.maxStars &&
                    star >= 0
                )
                    this.stars = this.stars === star ? star - 1 : star
                    this.$emit('input', this.stars)
              console.log(this.stars)
            },
        },
      mounted() {
          this.rate(0);
      }
    }
</script>
