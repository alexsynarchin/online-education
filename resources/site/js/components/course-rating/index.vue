<template>
    <section class="course-rating">
        <star-rating
            :star-size="10"
            :padding="2"
            :border-width="4"
            :show-rating="false"
            :read-only="true"
            :rating="rating"
            active-border-color="#FDC20B"
            border-color="rgba(201, 201, 201, 0.7)"
            active-color="#FDC20B"
            inactive-color="#fff"
            :round-start-rating="false"
            style="max-height: 14px"
        ></star-rating>
        <span class="course-rating__count">
            ({{count}})
        </span>
    </section>
</template>
<script>
import StarRating from 'vue-star-rating'
    export default {
        components:{
            StarRating
        },
        props:{
            rating:{
                type:Number,
                default:0
            },
            count: {
                type:Number,
                default:0
            }
        }
    }
</script>
