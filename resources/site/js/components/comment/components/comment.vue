<template>
    <section class="b-comment-item">
        <div class="b-comment-item__heading">
          <div class="b-comment-item__user b-comment-item-user">
            <figure class="b-comment-item-user__avatar">
              <img :src="comment.user.avatar" v-if="comment.user.avatar">
              <svg viewBox="0 0 40 40" v-else>
                <use xlink:href="/assets/site/images/sprites.svg?ver=19#sprite-user"></use>
              </svg>
            </figure>
            <section class="b-comment-item-user__content">
              <h5 class="b-comment-item-user__name">
                {{comment.user.name}}
              </h5>
              <div class="b-comment-item-user__rating"
                   v-if="(comment.rating)  && (comment.parent_id === 0)"
                  >
                <star-rating
                    :star-size="24"
                    :show-rating="false"
                    :read-only="true"
                    :rating="comment.rating.value"
                    active-color="#FDC20B"
                    inactive-color="rgba(253, 194, 11, 0.3)"
                    :round-start-rating="false"
                    v-if="comment.rating.value > 0"
                ></star-rating>
              </div>
            </section>
          </div>
            <span class="b-comment-item__datetime">
                {{comment.created_at}}
            </span>

        </div>
        <div class="b-comment-item__text">
            {{comment.comment}}
        </div>
      <div class="b-comment-item__footer">
        <button class="btn b-comment-item__answer" @click.prevent="answerComment(comment.id)">
          <svg viewBox="0 0 40 40">
            <use xlink:href="/assets/site/images/sprites.svg?ver=199#sprite-answer"></use>
          </svg>
          Ответить
        </button>

      </div>

      <div class="b-comment-item__border"></div>
      <section class="b-comment-item__answers" v-if="comment.children && comment.children.length">
          <comment v-on:answer-comment="answerComment" :key="child.id" v-for="(child, index) in comment.children" :comment="child"></comment>
      </section>
    </section>
</template>
<script>

    import StarRating from 'vue-star-rating'
    export default {
      name:"comment",
        components:{
           StarRating
        },
        props:['comment','auth'],
        data(){
            return {

             clicked:"",
            }
        },
        methods: {

          likeOrDislike(type) {
              if(this.auth) {
                axios.post('/api/comment/like-or-dislike', {id:this.comment.id, type:type})
                    .then((response) => {
                      this.comment.like= response.data.like;
                      this.comment.dislike = response.data.dislike;
                    })
                    .catch((error => {

                    }))
              } else {
                this.$emit('show-auth-modal')
              }

          },
          answerComment(id) {

              this.$emit('answer-comment',id)
          }
        },
    }
</script>
