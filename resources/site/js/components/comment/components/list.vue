<template>
  <section class="">
    <comment
            v-on:answer-comment="answerComment"
             @show-auth-modal="$emit('show-auth-modal')"
             :auth="auth"
             :key="comment.id"
             v-for = "(comment, index) in comments" :comment="comment"></comment>
  </section>
</template>
<script>
import comment from "./comment";
export default {
  components:{
    comment
  },
  props:{
    auth: {
      type:Boolean,
      required:true,
    },
    course_id: Number,
  },
  data() {
    return {
      comments:[],
      form: {}
    }
  },
  methods:{
    getComments() {
      axios.get('/api/comments/course/' + this.course_id)
          .then((response) => {
            this.comments = response.data;
            //this.$emit('comments-count', response.data.count)
          })
    },
    answerComment(id) {
      this.$emit('answer-comment',id)
    }
  },
  mounted() {
    this.getComments();
  }
}
</script>
