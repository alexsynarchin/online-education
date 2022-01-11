<template>
  <div v-if="!formSend">
  <div class="b-comment-form__heading">
    <user :user="user"
    ></user>
    <star-rating
        v-if="parent_id === 0 && !rating_set"
        :font-size="1.3"
        :show-title="true"
        v-model="form.rating"
    ></star-rating>
    <button class="btn button-transparent b-comment-filters__btn" @click.prevent="changeRating()" v-if="rating_set">
      Поменять оценку Курса
    </button>
  </div>
  <form class="b-comment-form">
    <div class="form-group">
      <textarea placeholder="Текст отзыва" class="form-control b-comment-form__input" v-model="form.comment" name="comment"  rows="6"
                :class="errors.has('comment') ? 'is-invalid':''"></textarea>
      <div class="invalid-feedback"  v-text="errors.get('comment')"></div>
    </div>
    <div class="b-comment-form__footer mt-4">
      <div class="order-md-1">
        <label class="form-checkbox " :class="errors.get('conf_agree') ? 'is-invalid':''">
        <span class="modal__conf-text">
             Согласен (-на) с
        <a class="landing-questions__link" href="/privacy" target="_blank">политикой
            конфиденциальности.</a>
        </span>
          <input type="checkbox" v-model="form.conf_agree" name="conf_agree" class="form-checkbox__input" checked>
          <span class="form-checkbox__checkmark"></span>
        </label>
        <div class="invalid-feedback" v-text="errors.get('conf_agree')"></div>
      </div>
      <button class="btn button b-comment-form__btn" @click.prevent="storeComment()">
        Опубликовать
      </button>

    </div>
  </form>
  </div>
  <div v-else>
    <div class="alert alert-primary" role="alert">
      Ваш комментарий будет опубликован после модерации
    </div>
    <button class="btn button-red" @click.prevent="newComment()">
      Новый комментарий
    </button>
    <button class="btn button-red" @click.prevent="close()">
      Закрыть
    </button>
  </div>
</template>
<script>
import StarRating from "../../star-rating/StarRating";
import { Errors } from  '@/common/js/services/errors.js';
import user from './user';
export default {
  props:{
    user:Object,
    building_id:Number,
    parent_id:Number,
  },
  components:{
    'StarRating':StarRating,
    'user':user,
  },
  data() {
    return {
      form:{
        rating:0,
        comment:"",
        conf_agree:true,
        user_id:this.user.id,
      },
      rating_set:false,
      formSend:false,
      errors: new Errors(),
    }
  },
  methods: {
    checkRatingSet() {
      axios.get('/comment/check-rating-set', {params:{
        user_id:this.user.id,
        building_id:this.building_id,
        }})
      .then((response) => {
        console.log(response.data);
        this.rating_set= response.data;
        console.log(response.data)
      })
      .catch((error) => {

      })
    },
    changeRating() {
      this.rating_set = false;
      this.$emit('changeRating');
    },
    close() {
      this.$emit('close')
    },
    newComment() {
      this.formSend = false;
      for (var key in this.form) {
        this.form['rating'] = 0;
        this.form['comment'] ="";
      }
    },
    storeComment() {
      if(this.parent_id != 0) {
        this.form['parent_id'] = this.parent_id;
      }
      axios.post('/api/comment/store', this.form)
          .then((response) => {
            this.$emit('store-comment');
            this.formSend = true;
            this.changeRating();
          })
          .catch((error) => {
            this.errors.record(error.response.data.errors);

          })
    }
  },
  mounted() {
    this.checkRatingSet()
  }
}
</script>
