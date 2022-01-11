<template>
  <section class="b-comment-user">
    <figure class="b-comment-user__avatar" :class="{'b-comment-user__avatar--no-img':!user.img}">
      <img :src="user.avatar" v-if="user.avatar">
      <svg viewBox="0 0 40 40" v-else>
        <use xlink:href="/assets/site/images/sprites.svg?ver=19#sprite-user"></use>
      </svg>
    </figure>
    <section class="b-comment-user__content">
      <h5 class="b-comment-user__title">{{user.name}}</h5>
      <div class="b-comment-user-bnts">
        <button class="b-comment-user__btn" @click.prevent="profile">
          Настройки
        </button>
        <button class="b-comment-user__btn" @click.prevent="logout">
          Выйти
        </button>
      </div>
    </section>
  </section>
</template>
<script>
export default {
  props:{
    user:Object,
  },
  methods:{
    logout() {
      this.$emit('logout');
    },
    profile() {
      this.$emit('profile');
    }
  }
}
</script>
