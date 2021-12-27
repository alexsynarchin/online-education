<template>
  <section class="b-slider-home">
    <swiper :options="swiperOption" class="b-main-slider">
        <swiper-slide v-for="(slideItem, index) in slideImage" :key="index">
          <div class="b-main-slide">
            <div class="b-main-slide__background" :style="{ backgroundImage: 'url(' + slideItem.src + ')' }"></div>
            <div class="container b-main-slide-des">
              <div class="row">
                <div class="col-lg-12">
                    <h2 class="b-main-slide-des__title" v-html="slideItem.title"></h2>
                    <div class="b-main-slide-des__text" v-html="slideItem.text"></div>
                </div>
              </div>
            </div>
          </div>
        </swiper-slide>

        <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
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
  data() {
    return {
        swiperOption: {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            pagination: {
              el: '.swiper-pagination',
              clickable: true
            }
        },
        slideImage: [
          { src: require('../../../../assets/images/glavBaner.jpg'),
            title: 'Преподаватели и уроки <br> общеобразовательных предметов',
            text: `<ul>
                  <li>
                    <p>Получайте и поддерживайте высокий  уровень знаний<br>
                  по любым предметам</p>
                  </li>
                  <li>
                    <p>Преподаватели вашего учебного заведения или другого<br> подготовят вас к контрольным, ЕГЭ, зачетам, дипломной<br>
                  работе и т.п.</p>
                  </li>
                  <li>
                    <p>Уроки здесь помогут закончить все образовательные<br> учреждения отличником</p>
                  </li>
                </ul> `
          },

            { src: require('../../../../assets/images/glavBaner.jpg'),
                title: 'Преподаватели и уроки <br> общеобразовательных предметов',
                text: `<ul>
                  <li>
                    <p>Получайте и поддерживайте высокий  уровень знаний<br>
                  по любым предметам</p>
                  </li>
                  <li>
                    <p>Преподаватели вашего учебного заведения или другого<br> подготовят вас к контрольным, ЕГЭ, зачетам, дипломной<br>
                  работе и т.п.</p>
                  </li>
                  <li>
                    <p>Уроки здесь помогут закончить все образовательные<br> учреждения отличником</p>
                  </li>
                </ul> `
            }
        ]
      }
  }
}
</script>

<style lang="stylus">
@import '../../../stylus/_mixins.styl'
@import '../../../stylus/_rapture.styl'

rupture.scale =       0    576px    768px    992px    1200px
rupture.scale-names =  'xs'     'sm'     'md'     'lg'      'xl'

.b-main-slider
  width 100%
  height 650px

.b-main-slide
  position relative
  width 100%
  height 100%
  display flex
  justify-content center

.b-main-slide__background
  width 100%
  height 100%
  background-size cover
  background-position 50% 50%
  background-repeat no-repeat
  +below(sm)
    background-position 78% 50%

.b-main-slide-des
  position absolute
  width 100%
  height 100%
  display flex
  flex-direction column
  justify-content center


.b-main-slide-des__title
  margin-bottom 30px
  font-family "RubikRegular"
  font-size rem(32px)
  font-weight 200
  color #fff
  +below(md)
    font-size rem(20px)
    margin-top 20px

.b-main-slide-des__text
  font-size rem(16px)
  color #fff
  +below(md)
    font-size rem(14px)
  li,p
    margin-bottom 30px
  li
    margin-left 18px


.b-main-slider .swiper-pagination
  .swiper-pagination-bullet
    width 15px
    height 15px
    background-color #D6D6D6
    &-active
      background-color #6A89CC

</style>
